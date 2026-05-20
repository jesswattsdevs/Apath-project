<?php
include "helpers.php";
include "connection.php";
require_login(array(1));

$currentPage = "check_pickup";
$volunteerId = (int) $_SESSION["user_id"];
$studentId = (int) ($_GET["s_id"] ?? $_POST["s_id"] ?? 0);
$student = null;
$message = "";
$isSuccess = false;

if ($studentId > 0) {
    $sql = "SELECT s_id, arrival_date, arrival_time FROM apath_student WHERE s_id = $studentId";
    $result = mysqli_query($dbc, $sql);
    if ($result && mysqli_num_rows($result) === 1) {
        $student = mysqli_fetch_assoc($result);
    }
}

if (!$student) {
    $message = "Student pickup request was not found.";
} elseif (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    if (($_POST["decision"] ?? "") === "confirm") {
        $checkSql = "SELECT p_id FROM apath_pickup WHERE s_id = $studentId AND v_id = $volunteerId";
        $checkResult = mysqli_query($dbc, $checkSql);
        if (!$checkResult || mysqli_num_rows($checkResult) === 0) {
            mysqli_query($dbc, "INSERT INTO apath_pickup (v_id, s_id, approved) VALUES ($volunteerId, $studentId, 0)");
        }
        $message = "Thank you for volunteering. You will see the detail information about this pickup task under Pickup Assignment once our team has reviewed and approved it.";
        $isSuccess = true;
    } else {
        header("Location:check_pickup_needs.php");
        exit();
    }
}
?>
<html>
<head>
    <title>Confirm Pickup</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Confirm Pickup Availability</p>
                <?php include "volunteer_nav.php"; ?>
                <?php if ($message !== "") { ?>
                    <div class="success<?php if (!$isSuccess) { echo " error-box"; } ?>"><?php echo h($message); ?></div>
                <?php } ?>
                <section class="panel">
                    <?php if ($student && !$isSuccess) { ?>
                        <h2>Pickup Confirmation</h2>
                        <p>Please confirm that you are available on <?php echo h($student["arrival_date"]); ?>, <?php echo h($student["arrival_time"]); ?> to pick up a student.</p>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="s_id" value="<?php echo $studentId; ?>">
                            <div class="actions">
                                <button class="button-link" type="submit" name="decision" value="cancel">Cancel</button>
                                <button class="button-link" type="submit" name="decision" value="confirm">Confirm</button>
                            </div>
                        </form>
                    <?php } elseif ($isSuccess) { ?>
                        <a class="button-link" href="pickup_assignment.php">Go To Pickup Assignment</a>
                    <?php } else { ?>
                        <a class="button-link" href="check_pickup_needs.php">Back To Check Pickup Needs</a>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
