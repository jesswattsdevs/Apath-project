<?php
include "helpers.php";
include "connection.php";
require_login(array(2));

$currentPage = "flight";
$studentId = (int) $_SESSION["user_id"];
$arrivalFlightNumber = "";
$arrivalAirlineName = "";
$arrivalDate = "";
$arrivalTime = "";
$luggageCount = "";
$leavingFlightNumber = "";
$leavingAirlineName = "";
$leavingDate = "";
$leavingTime = "";

$arrivalFlightNumberErr = "";
$arrivalAirlineNameErr = "";
$arrivalDateErr = "";
$arrivalTimeErr = "";
$luggageCountErr = "";
$leavingFlightNumberErr = "";
$leavingAirlineNameErr = "";
$leavingDateErr = "";
$leavingTimeErr = "";
$successMessage = "";

$loadSql = "SELECT * FROM apath_student WHERE s_id=$studentId";
$loadResult = mysqli_query($dbc, $loadSql);
if ($loadResult && mysqli_num_rows($loadResult) === 1) {
    $row = mysqli_fetch_assoc($loadResult);
    $arrivalFlightNumber = $row["arrival_flight_number"] ?? "";
    $arrivalAirlineName = $row["arrival_airline_name"] ?? "";
    $arrivalDate = $row["arrival_date"] ?? "";
    $arrivalTime = $row["arrival_time"] ?? "";
    $luggageCount = $row["luggage_count"] ?? "";
    $leavingFlightNumber = $row["leaving_flight_number"] ?? "";
    $leavingAirlineName = $row["leaving_airline_name"] ?? "";
    $leavingDate = $row["leaving_date"] ?? "";
    $leavingTime = $row["leaving_time"] ?? "";
}

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $arrivalFlightNumber = test_input($_POST["arrival_flight_number"] ?? "");
    $arrivalAirlineName = test_input($_POST["arrival_airline_name"] ?? "");
    $arrivalDate = test_input($_POST["arrival_date"] ?? "");
    $arrivalTime = test_input($_POST["arrival_time"] ?? "");
    $luggageCount = test_input($_POST["luggage_count"] ?? "");
    $leavingFlightNumber = test_input($_POST["leaving_flight_number"] ?? "");
    $leavingAirlineName = test_input($_POST["leaving_airline_name"] ?? "");
    $leavingDate = test_input($_POST["leaving_date"] ?? "");
    $leavingTime = test_input($_POST["leaving_time"] ?? "");
    $hasError = false;

    if ($arrivalFlightNumber === "") {
        $arrivalFlightNumberErr = "Arrival flight number is required.";
        $hasError = true;
    }

    if ($arrivalAirlineName === "") {
        $arrivalAirlineNameErr = "Arrival airline name is required.";
        $hasError = true;
    }

    if ($arrivalDate === "") {
        $arrivalDateErr = "Arrival date is required.";
        $hasError = true;
    }

    if ($arrivalTime === "") {
        $arrivalTimeErr = "Arrival time is required.";
        $hasError = true;
    }

    if ($luggageCount === "") {
        $luggageCountErr = "Number of luggage is required.";
        $hasError = true;
    }

    if ($leavingFlightNumber === "") {
        $leavingFlightNumberErr = "Leaving flight number is required.";
        $hasError = true;
    }

    if ($leavingAirlineName === "") {
        $leavingAirlineNameErr = "Leaving airline name is required.";
        $hasError = true;
    }

    if ($leavingDate === "") {
        $leavingDateErr = "Leaving date is required.";
        $hasError = true;
    }

    if ($leavingTime === "") {
        $leavingTimeErr = "Leaving time is required.";
        $hasError = true;
    }

    if (!$hasError) {
        upsert_student_shell($dbc, $studentId, $_SESSION["user_email"]);
        $safeArrivalFlight = mysqli_real_escape_string($dbc, $arrivalFlightNumber);
        $safeArrivalAirline = mysqli_real_escape_string($dbc, $arrivalAirlineName);
        $safeArrivalDate = mysqli_real_escape_string($dbc, $arrivalDate);
        $safeArrivalTime = mysqli_real_escape_string($dbc, $arrivalTime);
        $safeLuggage = mysqli_real_escape_string($dbc, $luggageCount);
        $safeFlight = mysqli_real_escape_string($dbc, $leavingFlightNumber);
        $safeAirline = mysqli_real_escape_string($dbc, $leavingAirlineName);
        $safeDate = mysqli_real_escape_string($dbc, $leavingDate);
        $safeTime = mysqli_real_escape_string($dbc, $leavingTime);
        $sql = "UPDATE apath_student
                SET arrival_flight_number='$safeArrivalFlight', arrival_airline_name='$safeArrivalAirline', arrival_date='$safeArrivalDate',
                    arrival_time='$safeArrivalTime', luggage_count='$safeLuggage', leaving_flight_number='$safeFlight',
                    leaving_airline_name='$safeAirline', leaving_date='$safeDate', leaving_time='$safeTime'
                WHERE s_id=$studentId";
        mysqli_query($dbc, $sql);
        $successMessage = "Flight information submitted successfully.";
    }
}
?>
<html>
<head>
    <title>Lab 7 - Student Flight Information</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Student Flight Information</p>
                <?php include "student_nav.php"; ?>
                <?php if ($successMessage !== "") { ?><div class="success"><?php echo $successMessage; ?></div><?php } ?>
                <section class="panel">
                    <h2>Flight Form</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <label for="arrival_flight_number">Arrival Flight Number <span class="required">*</span></label>
                            <input type="text" id="arrival_flight_number" name="arrival_flight_number" value="<?php echo $arrivalFlightNumber; ?>">
                            <?php if ($arrivalFlightNumberErr !== "") { ?><div class="error"><?php echo $arrivalFlightNumberErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="arrival_airline_name">Arrival Airline Name <span class="required">*</span></label>
                            <input type="text" id="arrival_airline_name" name="arrival_airline_name" value="<?php echo $arrivalAirlineName; ?>">
                            <?php if ($arrivalAirlineNameErr !== "") { ?><div class="error"><?php echo $arrivalAirlineNameErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="arrival_date">Arrival Date <span class="required">*</span></label>
                            <input type="text" id="arrival_date" name="arrival_date" placeholder="July 15" value="<?php echo $arrivalDate; ?>">
                            <?php if ($arrivalDateErr !== "") { ?><div class="error"><?php echo $arrivalDateErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="arrival_time">Arrival Time <span class="required">*</span></label>
                            <input type="text" id="arrival_time" name="arrival_time" placeholder="15:30" value="<?php echo $arrivalTime; ?>">
                            <?php if ($arrivalTimeErr !== "") { ?><div class="error"><?php echo $arrivalTimeErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="luggage_count">Number Of Luggage <span class="required">*</span></label>
                            <input type="text" id="luggage_count" name="luggage_count" value="<?php echo $luggageCount; ?>">
                            <?php if ($luggageCountErr !== "") { ?><div class="error"><?php echo $luggageCountErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="leaving_flight_number">Leaving Flight Number <span class="required">*</span></label>
                            <input type="text" id="leaving_flight_number" name="leaving_flight_number" value="<?php echo $leavingFlightNumber; ?>">
                            <?php if ($leavingFlightNumberErr !== "") { ?><div class="error"><?php echo $leavingFlightNumberErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="leaving_airline_name">Leaving Airline Name <span class="required">*</span></label>
                            <input type="text" id="leaving_airline_name" name="leaving_airline_name" value="<?php echo $leavingAirlineName; ?>">
                            <?php if ($leavingAirlineNameErr !== "") { ?><div class="error"><?php echo $leavingAirlineNameErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="leaving_date">Leaving Date <span class="required">*</span></label>
                            <input type="text" id="leaving_date" name="leaving_date" placeholder="MM/DD/YYYY" value="<?php echo $leavingDate; ?>">
                            <?php if ($leavingDateErr !== "") { ?><div class="error"><?php echo $leavingDateErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="leaving_time">Leaving Time <span class="required">*</span></label>
                            <input type="text" id="leaving_time" name="leaving_time" placeholder="10:30 AM" value="<?php echo $leavingTime; ?>">
                            <?php if ($leavingTimeErr !== "") { ?><div class="error"><?php echo $leavingTimeErr; ?></div><?php } ?>
                        </div>

                        <div class="actions">
                            <input type="submit" value="Submit Flight Information">
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
