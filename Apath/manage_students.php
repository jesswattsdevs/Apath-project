<?php
include "helpers.php";
include "connection.php";
require_login(array(0));
$currentPage = "students";

$sql = "SELECT u.id, u.email, s.first_name, s.last_name, s.phone, s.major, s.arrival_date, s.arrival_time
        FROM apath_users u
        LEFT JOIN apath_student s ON u.id = s.s_id
        WHERE u.type = 2
        ORDER BY u.id";
$result = mysqli_query($dbc, $sql);
?>
<html>
<head>
    <title>Manage Students</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Manage Students</p>
                <?php include "admin_nav.php"; ?>
                <section class="panel wide-panel">
                    <h2>Student Table</h2>
                    <table class="data-table">
                        <tr>
                            <th>S_ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Major</th>
                            <th>Arrival Date</th>
                            <th>Arrival Time</th>
                            <th>Delete</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><a href="edit_student.php?s_id=<?php echo $row["id"]; ?>"><?php echo $row["id"]; ?></a></td>
                                <td><?php echo $row["first_name"]; ?></td>
                                <td><?php echo $row["last_name"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["major"]; ?></td>
                                <td><?php echo $row["arrival_date"]; ?></td>
                                <td><?php echo $row["arrival_time"]; ?></td>
                                <td><a href="delete_student.php?s_id=<?php echo $row["id"]; ?>">Delete</a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
