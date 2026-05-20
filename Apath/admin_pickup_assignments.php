<?php
include "helpers.php";
include "connection.php";
require_login(array(0));

$currentPage = "pickup_assignments";
$sql = "SELECT s.first_name, s.last_name, s.gender, s.arrival_date, s.arrival_time, p.s_id, p.v_id, p.approved
        FROM apath_student s
        RIGHT JOIN apath_pickup p ON p.s_id = s.s_id
        ORDER BY s.arrival_date, s.arrival_time";
$result = mysqli_query($dbc, $sql);
?>
<html>
<head>
    <title>Assign Pickup Volunteers</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Assign Pickup Volunteers</p>
                <?php include "admin_nav.php"; ?>
                <section class="panel wide-panel">
                    <h2>To Confirm Or Approve</h2>
                    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                        <table class="data-table">
                            <tr>
                                <th>Approve</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Arriving Date</th>
                                <th>Arriving Time</th>
                                <th>V_ID</th>
                                <th>Already Approved?</th>
                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <?php if ((int) $row["approved"] === 1) { ?>
                                            Approved
                                        <?php } else { ?>
                                            <a href="admin_approve_pickup.php?s_id=<?php echo (int) $row["s_id"]; ?>&v_id=<?php echo (int) $row["v_id"]; ?>">Approve</a>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo h($row["first_name"]); ?></td>
                                    <td><?php echo h($row["last_name"]); ?></td>
                                    <td><?php echo h($row["gender"]); ?></td>
                                    <td><?php echo h($row["arrival_date"]); ?></td>
                                    <td><?php echo h($row["arrival_time"]); ?></td>
                                    <td><?php echo (int) $row["v_id"]; ?></td>
                                    <td><?php echo ((int) $row["approved"] === 1) ? "Yes" : "No"; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        <div class="message-box">No pickup requests have been submitted yet.</div>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
