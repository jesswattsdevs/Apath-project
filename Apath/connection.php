<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "apath";

$dbc = mysqli_connect($hostname, $username, $password, $dbname);

if (!$dbc) {
    die("Cannot connect to database. Update connection.php with your phpMyAdmin/MySQL database name and credentials.");
}
?>
