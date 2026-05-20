<?php
include "helpers.php";
include "connection.php";
require_login(array(1));

$currentPage = "assignment";
$volunteerId = (int) $_SESSION["user_id"];
$sql = "SELECT s.first_name, s.last_name, s.email, s.phone, s.gender, s.major, s.classification, s.arrival_flight_number, s.arrival_airline_name,
               s.arrival_date, s.arrival_time, s.luggage_count, s.leaving_flight_number, s.leaving_airline_name, s.leaving_date, s.leaving_time
        FROM apath_pickup p
        INNER JOIN apath_student s ON p.s_id = s.s_id
        WHERE p.v_id = $volunteerId AND p.approved = 1
        ORDER BY s.arrival_date, s.arrival_time";
$result = mysqli_query($dbc, $sql);
?>
<html>
<head>
    <title>Pickup Assignment</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Pickup Assignment</p>
                <?php include "volunteer_nav.php"; ?>
                <section class="panel wide-panel">
                    <h2>Approved Pickup Assignment</h2>
                    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="info-card">
                                <div class="info-grid">
                                    <div><strong>Name:</strong> <?php echo h($row["first_name"] . " " . $row["last_name"]); ?></div>
                                    <div><strong>Email:</strong> <?php echo h($row["email"]); ?></div>
                                    <div><strong>Phone:</strong> <?php echo h($row["phone"]); ?></div>
                                    <div><strong>Gender:</strong> <?php echo h($row["gender"]); ?></div>
                                    <div><strong>Major:</strong> <?php echo h($row["major"]); ?></div>
                                    <div><strong>Classification:</strong> <?php echo h($row["classification"]); ?></div>
                                    <div><strong>Arrival Flight:</strong> <?php echo h($row["arrival_flight_number"]); ?></div>
                                    <div><strong>Arrival Airline:</strong> <?php echo h($row["arrival_airline_name"]); ?></div>
                                    <div><strong>Arrival Date:</strong> <?php echo h($row["arrival_date"]); ?></div>
                                    <div><strong>Arrival Time:</strong> <?php echo h($row["arrival_time"]); ?></div>
                                    <div><strong>Number Of Luggage:</strong> <?php echo h($row["luggage_count"]); ?></div>
                                    <div><strong>Leaving Flight:</strong> <?php echo h($row["leaving_flight_number"]); ?></div>
                                    <div><strong>Leaving Airline:</strong> <?php echo h($row["leaving_airline_name"]); ?></div>
                                    <div><strong>Leaving Date:</strong> <?php echo h($row["leaving_date"]); ?></div>
                                    <div><strong>Leaving Time:</strong> <?php echo h($row["leaving_time"]); ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="message-box">You do not have an approved pickup assignment yet.</div>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
