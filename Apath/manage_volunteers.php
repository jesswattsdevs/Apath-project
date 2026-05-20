<?php
include "helpers.php";
include "connection.php";
require_login(array(0));
$currentPage = "volunteers";

$sql = "SELECT u.id, u.email, v.first_name, v.last_name, v.phone, v.car_model, v.car_year
        FROM apath_users u
        LEFT JOIN apath_volunteer v ON u.id = v.v_id
        WHERE u.type = 1
        ORDER BY u.id";
$result = mysqli_query($dbc, $sql);
?>
<html>
<head>
    <title>Manage Volunteers</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Manage Volunteers</p>
                <?php include "admin_nav.php"; ?>
                <section class="panel wide-panel">
                    <h2>Volunteer Table</h2>
                    <table class="data-table">
                        <tr>
                            <th>V_ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Car Model</th>
                            <th>Year</th>
                            <th>Delete</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><a href="edit_volunteer.php?v_id=<?php echo $row["id"]; ?>"><?php echo $row["id"]; ?></a></td>
                                <td><?php echo $row["first_name"]; ?></td>
                                <td><?php echo $row["last_name"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["car_model"]; ?></td>
                                <td><?php echo $row["car_year"]; ?></td>
                                <td><a href="delete_volunteer.php?v_id=<?php echo $row["id"]; ?>">Delete</a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
