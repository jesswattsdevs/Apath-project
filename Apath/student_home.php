<?php
include "helpers.php";
require_login(array(2));
$currentPage = "home";
?>
<html>
<head>
    <title>APATH Student Home</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Student Home Page</p>
                <?php include "student_nav.php"; ?>
                <section class="panel">
                    <h2>Welcome Student</h2>
                    <p>Please complete your personal profile and flight information so the APATH team can coordinate your airport pickup.</p>
                    <ul>
                        <li>Use email as your login name.</li>
                        <li>Flight Information now includes your arrival date, arrival time, and luggage.</li>
                        <li>Pickup Information will show your approved volunteer once a pickup request has been reviewed.</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
