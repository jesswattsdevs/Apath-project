<?php
include "helpers.php";

$currentPage = "about";
?>
<html>
<head>
    <title>About APATH</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">About</p>
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
                    <img class="hero-photo" src="Atlanta.png" alt="Atlanta skyline at sunset">
                    <h2>Atlanta, Georgia</h2>
                    <p>Atlanta is a major and one of the largest cities in Georgia, known for its strong economy and cultural influence.</p>
                    <p>Its home to major companies like The Coca-Cola Factory and popular attractions like Georgia Aquarium.</p>
                        <p> Serves as a major transportation hub with Hartsfield-Jackson Atlanta International Airport</p>
                        
                    <h2>About This Website</h2>
                    <p>APATH helps international students connect with volunteers for airport pickup. Students can share their profile and flight details, volunteers can offer pickup help, and admins can review and approve each assignment.</p>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
