<?php
include "helpers.php";
include "connection.php";
require_login(array(2));
$currentPage = "pickup";
$studentId = (int) $_SESSION["user_id"];
$pickupMessage = "We are working on finding a volunteer to pick you up from the airport; information will be available later.";
$volunteer = null;
$setupMessage = "";

try {
    $sql = "SELECT p.*, v.first_name, v.last_name, v.email, v.phone, v.gender, v.car_make, v.car_model, v.car_year, v.car_color, v.car_plate, v.seats_available
            FROM apath_pickup p
            INNER JOIN apath_volunteer v ON p.v_id = v.v_id
            WHERE p.s_id = $studentId AND p.approved = 1
            LIMIT 1";
    $result = mysqli_query($dbc, $sql);
    if ($result && mysqli_num_rows($result) === 1) {
        $volunteer = mysqli_fetch_assoc($result);
    }
} catch (mysqli_sql_exception $e) {
    $setupMessage = "Pickup setup is not finished yet. The database still needs the Phase 3/4 pickup table before this page can show assignments.";
}
?>
<html>
<head>
    <title>Lab 7 - Pickup Information</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Pickup Information</p>
                <?php include "student_nav.php"; ?>
                <section class="panel">
                    <h2>Airport Pickup Status</h2>
                    <?php if ($setupMessage !== "") { ?>
                        <div class="message-box">
                            <?php echo h($setupMessage); ?>
                        </div>
                    <?php } elseif ($volunteer) { ?>
                        <table class="data-table">
                            <tr><th>Volunteer</th><td><?php echo h($volunteer["first_name"] . " " . $volunteer["last_name"]); ?></td></tr>
                            <tr><th>Email</th><td><?php echo h($volunteer["email"]); ?></td></tr>
                            <tr><th>Phone</th><td><?php echo h($volunteer["phone"]); ?></td></tr>
                            <tr><th>Gender</th><td><?php echo h($volunteer["gender"]); ?></td></tr>
                            <tr><th>Car</th><td><?php echo h(trim($volunteer["car_year"] . " " . $volunteer["car_make"] . " " . $volunteer["car_model"])); ?></td></tr>
                            <tr><th>Color</th><td><?php echo h($volunteer["car_color"]); ?></td></tr>
                            <tr><th>License Plate</th><td><?php echo h($volunteer["car_plate"]); ?></td></tr>
                            <tr><th>Seats Available</th><td><?php echo h($volunteer["seats_available"]); ?></td></tr>
                        </table>
                    <?php } else { ?>
                        <div class="message-box">
                            <?php echo $pickupMessage; ?>
                        </div>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
