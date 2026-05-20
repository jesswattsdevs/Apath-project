<?php
include "helpers.php";
require_login(array(2));
$currentPage = "temp-info";
?>
<html>
<head>
    <title>Lab 7 - Temp Housing Information</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Temp Housing Information</p>
                <?php include "student_nav.php"; ?>
                <section class="panel">
                    <h2>Temporary Housing Status</h2>
                    <div class="message-box">
                        We are working on finding a hosting family for your temporary housing need; information will be available later.
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
