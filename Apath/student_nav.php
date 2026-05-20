<?php
$currentPage = $currentPage ?? "";
?>
<div class="nav-links">
    <a href="student_home.php" <?php if ($currentPage === "home") echo 'class="active"'; ?>>Home</a>
    <a href="student_profile.php" <?php if ($currentPage === "profile") echo 'class="active"'; ?>>Personal Profile</a>
    <a href="student_flight.php" <?php if ($currentPage === "flight") echo 'class="active"'; ?>>Flight Information</a>
    <a href="pickup_information.php" <?php if ($currentPage === "pickup") echo 'class="active"'; ?>>Pickup Information</a>
    <a href="about.php" <?php if ($currentPage === "about") echo 'class="active"'; ?>>About</a>
    <a href="contact.php" <?php if ($currentPage === "contact") echo 'class="active"'; ?>>Contact</a>
    <a href="logout.php">Logout</a>
</div>
