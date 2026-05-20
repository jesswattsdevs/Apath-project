<?php
include "helpers.php";
include "connection.php";
require_login(array(1));

$currentPage = "check_pickup";
$volunteerId = (int) $_SESSION["user_id"];
$hasArrivalColumns = has_column($dbc, "apath_student", "arrival_date")
    && has_column($dbc, "apath_student", "arrival_time")
    && has_column($dbc, "apath_pickup", "approved");
$students = false;
$message = "";

if ($hasArrivalColumns) {
    $sql = "SELECT s.s_id, s.arrival_date, s.arrival_time, s.major
            FROM apath_student s
            LEFT JOIN apath_pickup approved_pickup ON approved_pickup.s_id = s.s_id AND approved_pickup.approved = 1
            LEFT JOIN apath_pickup my_request ON my_request.s_id = s.s_id AND my_request.v_id = $volunteerId
            WHERE s.arrival_date <> '' AND s.arrival_time <> '' AND approved_pickup.p_id IS NULL AND my_request.p_id IS NULL
            ORDER BY s.arrival_date, s.arrival_time";
    $students = mysqli_query($dbc, $sql);
} else {
    $message = "Update your database with the latest schema so arrival fields and pickup requests are available.";
}
?>
<html>
<head>
    <title>Check Pickup Needs</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Check Pickup Needs</p>
                <?php include "volunteer_nav.php"; ?>
                <section class="panel wide-panel">
                    <h2>Students Needing Pickup</h2>
                    <?php if ($message !== "") { ?>
                        <div class="message-box"><?php echo h($message); ?></div>
                    <?php } elseif ($students && mysqli_num_rows($students) > 0) { ?>
                        <table class="data-table">
                            <tr>
                                <th>Pickup</th>
                                <th>Arriving Date</th>
                                <th>Arriving Time</th>
                                <th>Major</th>
                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($students)) { ?>
                                <tr>
                                    <td><a href="volunteer_pickup_confirm.php?s_id=<?php echo (int) $row["s_id"]; ?>">Pickup</a></td>
                                    <td><?php echo h($row["arrival_date"]); ?></td>
                                    <td><?php echo h($row["arrival_time"]); ?></td>
                                    <td><?php echo h($row["major"]); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        <div class="message-box">There are no open pickup requests right now.</div>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
