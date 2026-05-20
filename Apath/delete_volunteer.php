<?php
include "helpers.php";
include "connection.php";
require_login(array(0));
$currentPage = "volunteers";

$volunteerId = (int) ($_GET["v_id"] ?? $_POST["v_id"] ?? 0);
$sql = "SELECT u.id, u.email, v.first_name, v.last_name FROM apath_users u LEFT JOIN apath_volunteer v ON u.id=v.v_id WHERE u.id=$volunteerId AND u.type=1";
$result = mysqli_query($dbc, $sql);
$volunteer = $result ? mysqli_fetch_assoc($result) : null;

if ($volunteer && isset($_POST["confirm_delete"])) {
    mysqli_query($dbc, "DELETE FROM apath_volunteer WHERE v_id=$volunteerId");
    mysqli_query($dbc, "DELETE FROM apath_users WHERE id=$volunteerId AND type=1");
    header("Location:manage_volunteers.php");
    exit();
}
?>
<html>
<head>
    <title>Delete Volunteer</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell"><div class="hero"><div class="hero-inner">
        <h1>APATH</h1>
        <p class="subtitle">Delete Volunteer</p>
        <?php include "admin_nav.php"; ?>
        <section class="panel">
            <h2>Confirm Delete</h2>
            <?php if ($volunteer) { ?>
                <p>Are you sure you want to delete volunteer <?php echo $volunteer["first_name"] . " " . $volunteer["last_name"]; ?>?</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="v_id" value="<?php echo $volunteerId; ?>">
                    <input type="submit" name="confirm_delete" value="Confirm Delete">
                </form>
            <?php } ?>
        </section>
    </div></div></div>
</body>
</html>
