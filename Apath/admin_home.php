<?php
include "helpers.php";
require_login(array(0));
$currentPage = "home";
?>
<html>
<head>
    <title>APATH Admin Home</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Admin Home Page</p>
                <?php include "admin_nav.php"; ?>
                <section class="panel">
                    <h2>Administration</h2>
                    <p>Use the links above to manage student and volunteer records, then review pickup requests and approve volunteer assignments.</p>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
