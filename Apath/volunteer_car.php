<?php
include "helpers.php";
include "connection.php";
require_login(array(1));

$currentPage = "car";
$volunteerId = (int) $_SESSION["user_id"];
$carMake = "";
$carModel = "";
$carYear = "";
$carColor = "";
$carPlate = "";
$seatsAvailable = "";
$message = "";

$sql = "SELECT * FROM apath_volunteer WHERE v_id=$volunteerId";
$result = mysqli_query($dbc, $sql);
if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $carMake = $row["car_make"];
    $carModel = $row["car_model"];
    $carYear = $row["car_year"];
    $carColor = $row["car_color"];
    $carPlate = $row["car_plate"];
    $seatsAvailable = $row["seats_available"];
}

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $carMake = test_input($_POST["car_make"] ?? "");
    $carModel = test_input($_POST["car_model"] ?? "");
    $carYear = test_input($_POST["car_year"] ?? "");
    $carColor = test_input($_POST["car_color"] ?? "");
    $carPlate = test_input($_POST["car_plate"] ?? "");
    $seatsAvailable = test_input($_POST["seats_available"] ?? "");

    $safeMake = mysqli_real_escape_string($dbc, $carMake);
    $safeModel = mysqli_real_escape_string($dbc, $carModel);
    $safeYear = mysqli_real_escape_string($dbc, $carYear);
    $safeColor = mysqli_real_escape_string($dbc, $carColor);
    $safePlate = mysqli_real_escape_string($dbc, $carPlate);
    $safeSeats = mysqli_real_escape_string($dbc, $seatsAvailable);

    upsert_volunteer_shell($dbc, $volunteerId, $_SESSION["user_email"]);
    $save = "UPDATE apath_volunteer SET car_make='$safeMake', car_model='$safeModel', car_year='$safeYear', car_color='$safeColor', car_plate='$safePlate', seats_available='$safeSeats' WHERE v_id=$volunteerId";
    mysqli_query($dbc, $save);
    $message = "Car information saved successfully.";
}
?>
<html>
<head>
    <title>Volunteer Car Information</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Volunteer Car Information</p>
                <?php include "volunteer_nav.php"; ?>
                <?php if ($message !== "") { ?><div class="success"><?php echo $message; ?></div><?php } ?>
                <section class="panel">
                    <h2>Car Information</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row"><label for="car_make">Car Make</label><input type="text" id="car_make" name="car_make" value="<?php echo $carMake; ?>"></div>
                        <div class="row"><label for="car_model">Car Model</label><input type="text" id="car_model" name="car_model" value="<?php echo $carModel; ?>"></div>
                        <div class="row"><label for="car_year">Year</label><input type="text" id="car_year" name="car_year" value="<?php echo $carYear; ?>"></div>
                        <div class="row"><label for="car_color">Color</label><input type="text" id="car_color" name="car_color" value="<?php echo $carColor; ?>"></div>
                        <div class="row"><label for="car_plate">License Plate</label><input type="text" id="car_plate" name="car_plate" value="<?php echo $carPlate; ?>"></div>
                        <div class="row"><label for="seats_available">Seats Available</label><input type="text" id="seats_available" name="seats_available" value="<?php echo $seatsAvailable; ?>"></div>
                        <div class="actions"><input type="submit" value="Save Car Information"></div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
