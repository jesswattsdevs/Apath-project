<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function require_login($allowedTypes = array())
{
    if (!isset($_SESSION["user_id"])) {
        header("Location:index.php");
        exit();
    }

    if (!empty($allowedTypes) && !in_array($_SESSION["user_type"], $allowedTypes, true)) {
        redirect_to_home($_SESSION["user_type"]);
    }
}

function redirect_to_home($userType)
{
    if ($userType == 0) {
        header("Location:admin_home.php");
    } elseif ($userType == 1) {
        header("Location:volunteer_home.php");
    } else {
        header("Location:student_home.php");
    }
    exit();
}

function upsert_student_shell($dbc, $studentId, $email)
{
    $studentId = (int) $studentId;
    $safeEmail = mysqli_real_escape_string($dbc, $email);
    $sql = "INSERT INTO apath_student (s_id, email) VALUES ($studentId, '$safeEmail')
            ON DUPLICATE KEY UPDATE email='$safeEmail'";
    mysqli_query($dbc, $sql);
}

function upsert_volunteer_shell($dbc, $volunteerId, $email)
{
    $volunteerId = (int) $volunteerId;
    $safeEmail = mysqli_real_escape_string($dbc, $email);
    $sql = "INSERT INTO apath_volunteer (v_id, email) VALUES ($volunteerId, '$safeEmail')
            ON DUPLICATE KEY UPDATE email='$safeEmail'";
    mysqli_query($dbc, $sql);
}

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES);
}

function has_column($dbc, $tableName, $columnName)
{
    $safeTable = mysqli_real_escape_string($dbc, $tableName);
    $safeColumn = mysqli_real_escape_string($dbc, $columnName);
    $sql = "SHOW COLUMNS FROM `$safeTable` LIKE '$safeColumn'";
    $result = mysqli_query($dbc, $sql);
    return $result && mysqli_num_rows($result) > 0;
}
?>
