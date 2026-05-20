<?php
$currentPage = $currentPage ?? "";
?>
<div class="nav-links">
    <a href="volunteer_home.php" <?php if ($currentPage === "home") echo 'class="active"'; ?>>Home</a>
    <a href="volunteer_profile.php" <?php if ($currentPage === "profile") echo 'class="active"'; ?>>Personal Profile</a>
    <a href="volunteer_car.php" <?php if ($currentPage === "car") echo 'class="active"'; ?>>Car Information</a>
    <a href="check_pickup_needs.php" <?php if ($currentPage === "check_pickup") echo 'class="active"'; ?>>Check Pickup Needs</a>
    <a href="pickup_assignment.php" <?php if ($currentPage === "assignment") echo 'class="active"'; ?>>Pickup Assignment</a>
    <a href="about.php" <?php if ($currentPage === "about") echo 'class="active"'; ?>>About</a>
    <a href="contact.php" <?php if ($currentPage === "contact") echo 'class="active"'; ?>>Contact</a>
    <a href="logout.php">Logout</a>
</div>
