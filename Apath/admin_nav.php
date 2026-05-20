<?php
$currentPage = $currentPage ?? "";
?>
<div class="nav-links">
    <a href="admin_home.php" <?php if ($currentPage === "home") echo 'class="active"'; ?>>Home</a>
    <a href="manage_students.php" <?php if ($currentPage === "students") echo 'class="active"'; ?>>Manage Students</a>
    <a href="manage_volunteers.php" <?php if ($currentPage === "volunteers") echo 'class="active"'; ?>>Manage Volunteers</a>
    <a href="admin_pickup_assignments.php" <?php if ($currentPage === "pickup_assignments") echo 'class="active"'; ?>>Assign Pickup Volunteers</a>
    <a href="about.php" <?php if ($currentPage === "about") echo 'class="active"'; ?>>About</a>
    <a href="contact.php" <?php if ($currentPage === "contact") echo 'class="active"'; ?>>Contact</a>
    <a href="logout.php">Logout</a>
</div>
