<?php
include "helpers.php";
include "connection.php";
require_login(array(0));

$currentPage = "pickup_assignments";
$studentId = (int) ($_GET["s_id"] ?? $_POST["s_id"] ?? 0);
$volunteerId = (int) ($_GET["v_id"] ?? $_POST["v_id"] ?? 0);
$record = null;
$message = "";
$isSuccess = false;

$sql = "SELECT p.s_id, p.v_id, p.approved, s.first_name AS student_first_name, s.last_name AS student_last_name, s.arrival_date, s.arrival_time,
               v.first_name AS volunteer_first_name, v.last_name AS volunteer_last_name
        FROM apath_pickup p
        INNER JOIN apath_student s ON p.s_id = s.s_id
        INNER JOIN apath_volunteer v ON p.v_id = v.v_id
        WHERE p.s_id = $studentId AND p.v_id = $volunteerId
        LIMIT 1";
$result = mysqli_query($dbc, $sql);
if ($result && mysqli_num_rows($result) === 1) {
    $record = mysqli_fetch_assoc($result);
}

if (!$record) {
    $message = "That pickup record was not found.";
} elseif (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    if (($_POST["decision"] ?? "") === "confirm") {
        $approvedCheck = mysqli_query($dbc, "SELECT p_id FROM apath_pickup WHERE s_id = $studentId AND approved = 1");
        if ($approvedCheck && mysqli_num_rows($approvedCheck) === 0) {
            mysqli_query($dbc, "UPDATE apath_pickup SET approved = 1 WHERE s_id = $studentId AND v_id = $volunteerId");
            $message = "Pickup table has been updated.";
            $isSuccess = true;
        } else {
            $message = "This student already has an approved pickup volunteer.";
        }
    } else {
        header("Location:admin_pickup_assignments.php");
        exit();
    }
}
?>
<html>
<head>
    <title>Approve Pickup</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Approve Pickup Volunteer</p>
                <?php include "admin_nav.php"; ?>
                <?php if ($message !== "") { ?>
                    <div class="success<?php if (!$isSuccess) { echo " error-box"; } ?>"><?php echo h($message); ?></div>
                <?php } ?>
                <section class="panel">
                    <?php if ($record && !$isSuccess) { ?>
                        <h2>Approval Confirmation</h2>
                        <p>Please confirm that you want to approve volunteer: <?php echo h($record["volunteer_first_name"] . " " . $record["volunteer_last_name"]); ?> to pick up student: <?php echo h($record["student_first_name"] . " " . $record["student_last_name"]); ?> on <?php echo h($record["arrival_date"]); ?>, <?php echo h($record["arrival_time"]); ?>.</p>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="s_id" value="<?php echo $studentId; ?>">
                            <input type="hidden" name="v_id" value="<?php echo $volunteerId; ?>">
                            <div class="actions">
                                <button class="button-link" type="submit" name="decision" value="cancel">Cancel</button>
                                <button class="button-link" type="submit" name="decision" value="confirm">Confirm</button>
                            </div>
                        </form>
                    <?php } else { ?>
                        <a class="button-link" href="admin_pickup_assignments.php">Back To Pickup Assignments</a>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
