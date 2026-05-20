<?php
include "helpers.php";

$currentPage = "contact";
?>
<html>
<head>
    <title>Contact APATH</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Contact</p>
                <?php
                if (isset($_SESSION["user_type"])) {
                    if ($_SESSION["user_type"] === 0) {
                        include "admin_nav.php";
                    } elseif ($_SESSION["user_type"] === 1) {
                        include "volunteer_nav.php";
                    } else {
                        include "student_nav.php";
                    }
                }
                ?>
                <section class="panel">
                    <h2>Contact Information</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <strong>Email</strong>
                            <p>apath@ggc.edu</p>
                        </div>
                        <div class="info-card">
                            <strong>Phone</strong>
                            <p>678-555-2026</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
