<?php
include "helpers.php";
include "connection.php";
require_login(array(0));
$currentPage = "students";

$studentId = (int) ($_GET["s_id"] ?? $_POST["s_id"] ?? 0);
$message = "";

$sql = "SELECT u.id, u.email, s.* FROM apath_users u LEFT JOIN apath_student s ON u.id=s.s_id WHERE u.id=$studentId AND u.type=2";
$result = mysqli_query($dbc, $sql);
$student = $result ? mysqli_fetch_assoc($result) : null;

if (!$student) {
    $message = "Student record not found.";
} elseif (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $firstName = mysqli_real_escape_string($dbc, test_input($_POST["first_name"] ?? ""));
    $lastName = mysqli_real_escape_string($dbc, test_input($_POST["last_name"] ?? ""));
    $email = mysqli_real_escape_string($dbc, test_input($_POST["email"] ?? ""));
    $phone = mysqli_real_escape_string($dbc, test_input($_POST["phone"] ?? ""));
    $major = mysqli_real_escape_string($dbc, test_input($_POST["major"] ?? ""));
    $arrivalFlightNumber = mysqli_real_escape_string($dbc, test_input($_POST["arrival_flight_number"] ?? ""));
    $arrivalAirlineName = mysqli_real_escape_string($dbc, test_input($_POST["arrival_airline_name"] ?? ""));
    $arrivalDate = mysqli_real_escape_string($dbc, test_input($_POST["arrival_date"] ?? ""));
    $arrivalTime = mysqli_real_escape_string($dbc, test_input($_POST["arrival_time"] ?? ""));
    $luggageCount = mysqli_real_escape_string($dbc, test_input($_POST["luggage_count"] ?? ""));
    $leavingFlightNumber = mysqli_real_escape_string($dbc, test_input($_POST["leaving_flight_number"] ?? ""));
    $leavingAirlineName = mysqli_real_escape_string($dbc, test_input($_POST["leaving_airline_name"] ?? ""));
    $leavingDate = mysqli_real_escape_string($dbc, test_input($_POST["leaving_date"] ?? ""));
    $leavingTime = mysqli_real_escape_string($dbc, test_input($_POST["leaving_time"] ?? ""));

    mysqli_query($dbc, "UPDATE apath_users SET email='$email' WHERE id=$studentId");
    mysqli_query($dbc, "INSERT INTO apath_student (s_id, email, first_name, last_name, phone, major, arrival_flight_number, arrival_airline_name, arrival_date, arrival_time, luggage_count, leaving_flight_number, leaving_airline_name, leaving_date, leaving_time)
                        VALUES ($studentId, '$email', '$firstName', '$lastName', '$phone', '$major', '$arrivalFlightNumber', '$arrivalAirlineName', '$arrivalDate', '$arrivalTime', '$luggageCount', '$leavingFlightNumber', '$leavingAirlineName', '$leavingDate', '$leavingTime')
                        ON DUPLICATE KEY UPDATE email='$email', first_name='$firstName', last_name='$lastName', phone='$phone', major='$major',
                        arrival_flight_number='$arrivalFlightNumber', arrival_airline_name='$arrivalAirlineName', arrival_date='$arrivalDate',
                        arrival_time='$arrivalTime', luggage_count='$luggageCount',
                        leaving_flight_number='$leavingFlightNumber', leaving_airline_name='$leavingAirlineName', leaving_date='$leavingDate', leaving_time='$leavingTime'");
    $message = "Student information updated.";
    $result = mysqli_query($dbc, $sql);
    $student = $result ? mysqli_fetch_assoc($result) : null;
}
?>
<html>
<head>
    <title>Edit Student</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell"><div class="hero"><div class="hero-inner">
        <h1>APATH</h1>
        <p class="subtitle">Edit Student</p>
        <?php include "admin_nav.php"; ?>
        <?php if ($message !== "") { ?><div class="success"><?php echo $message; ?></div><?php } ?>
        <section class="panel">
            <h2>Student Detail</h2>
            <?php if ($student) { ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="s_id" value="<?php echo $studentId; ?>">
                <div class="row"><label>S_ID</label><input type="text" value="<?php echo $studentId; ?>" readonly></div>
                <div class="row"><label>First Name</label><input type="text" name="first_name" value="<?php echo $student["first_name"]; ?>"></div>
                <div class="row"><label>Last Name</label><input type="text" name="last_name" value="<?php echo $student["last_name"]; ?>"></div>
                <div class="row"><label>Email</label><input type="email" name="email" value="<?php echo $student["email"]; ?>"></div>
                <div class="row"><label>Phone</label><input type="text" name="phone" value="<?php echo $student["phone"]; ?>"></div>
                <div class="row"><label>Major</label><input type="text" name="major" value="<?php echo $student["major"]; ?>"></div>
                <div class="row"><label>Arrival Flight Number</label><input type="text" name="arrival_flight_number" value="<?php echo $student["arrival_flight_number"]; ?>"></div>
                <div class="row"><label>Arrival Airline Name</label><input type="text" name="arrival_airline_name" value="<?php echo $student["arrival_airline_name"]; ?>"></div>
                <div class="row"><label>Arrival Date</label><input type="text" name="arrival_date" value="<?php echo $student["arrival_date"]; ?>"></div>
                <div class="row"><label>Arrival Time</label><input type="text" name="arrival_time" value="<?php echo $student["arrival_time"]; ?>"></div>
                <div class="row"><label>Number Of Luggage</label><input type="text" name="luggage_count" value="<?php echo $student["luggage_count"]; ?>"></div>
                <div class="row"><label>Leaving Flight Number</label><input type="text" name="leaving_flight_number" value="<?php echo $student["leaving_flight_number"]; ?>"></div>
                <div class="row"><label>Leaving Airline Name</label><input type="text" name="leaving_airline_name" value="<?php echo $student["leaving_airline_name"]; ?>"></div>
                <div class="row"><label>Leaving Date</label><input type="text" name="leaving_date" value="<?php echo $student["leaving_date"]; ?>"></div>
                <div class="row"><label>Leaving Time</label><input type="text" name="leaving_time" value="<?php echo $student["leaving_time"]; ?>"></div>
                <div class="actions"><input type="submit" value="Update Student"></div>
            </form>
            <?php } ?>
        </section>
    </div></div></div>
</body>
</html>
