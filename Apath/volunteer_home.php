<?php
include "helpers.php";
require_login(array(1));
$currentPage = "home";
?>
<html>
<head>
    <title>APATH Volunteer Home</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Volunteer Home Page</p>
                <?php include "volunteer_nav.php"; ?>
                <section class="panel">
                    <h2>Welcome Volunteer</h2>
                    <p>Please complete your personal profile and car information, then use Check Pickup Needs to volunteer for upcoming airport pickups.</p>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
