<?php
include "helpers.php";
include "connection.php";
require_login(array(0));
$currentPage = "students";

$studentId = (int) ($_GET["s_id"] ?? $_POST["s_id"] ?? 0);
$message = "";
$sql = "SELECT u.id, u.email, s.first_name, s.last_name FROM apath_users u LEFT JOIN apath_student s ON u.id=s.s_id WHERE u.id=$studentId AND u.type=2";
$result = mysqli_query($dbc, $sql);
$student = $result ? mysqli_fetch_assoc($result) : null;

if ($student && isset($_POST["confirm_delete"])) {
    mysqli_query($dbc, "DELETE FROM apath_student WHERE s_id=$studentId");
    mysqli_query($dbc, "DELETE FROM apath_users WHERE id=$studentId AND type=2");
    header("Location:manage_students.php");
    exit();
}
?>
<html>
<head>
    <title>Delete Student</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell"><div class="hero"><div class="hero-inner">
        <h1>APATH</h1>
        <p class="subtitle">Delete Student</p>
        <?php include "admin_nav.php"; ?>
        <section class="panel">
            <h2>Confirm Delete</h2>
            <?php if ($student) { ?>
                <p>Are you sure you want to delete student <?php echo $student["first_name"] . " " . $student["last_name"]; ?>?</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="s_id" value="<?php echo $studentId; ?>">
                    <input type="submit" name="confirm_delete" value="Confirm Delete">
                </form>
            <?php } ?>
        </section>
    </div></div></div>
</body>
</html>
