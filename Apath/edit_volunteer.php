<?php
include "helpers.php";
include "connection.php";
require_login(array(0));
$currentPage = "volunteers";

$volunteerId = (int) ($_GET["v_id"] ?? $_POST["v_id"] ?? 0);
$message = "";

$sql = "SELECT u.id, u.email, v.* FROM apath_users u LEFT JOIN apath_volunteer v ON u.id=v.v_id WHERE u.id=$volunteerId AND u.type=1";
$result = mysqli_query($dbc, $sql);
$volunteer = $result ? mysqli_fetch_assoc($result) : null;

if (!$volunteer) {
    $message = "Volunteer record not found.";
} elseif (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $firstName = mysqli_real_escape_string($dbc, test_input($_POST["first_name"] ?? ""));
    $lastName = mysqli_real_escape_string($dbc, test_input($_POST["last_name"] ?? ""));
    $email = mysqli_real_escape_string($dbc, test_input($_POST["email"] ?? ""));
    $phone = mysqli_real_escape_string($dbc, test_input($_POST["phone"] ?? ""));
    $carModel = mysqli_real_escape_string($dbc, test_input($_POST["car_model"] ?? ""));
    $carYear = mysqli_real_escape_string($dbc, test_input($_POST["car_year"] ?? ""));

    mysqli_query($dbc, "UPDATE apath_users SET email='$email' WHERE id=$volunteerId");
    mysqli_query($dbc, "INSERT INTO apath_volunteer (v_id, email, first_name, last_name, phone, car_model, car_year)
                        VALUES ($volunteerId, '$email', '$firstName', '$lastName', '$phone', '$carModel', '$carYear')
                        ON DUPLICATE KEY UPDATE email='$email', first_name='$firstName', last_name='$lastName', phone='$phone',
                        car_model='$carModel', car_year='$carYear'");
    $message = "Volunteer information updated.";
    $result = mysqli_query($dbc, $sql);
    $volunteer = $result ? mysqli_fetch_assoc($result) : null;
}
?>
<html>
<head>
    <title>Edit Volunteer</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell"><div class="hero"><div class="hero-inner">
        <h1>APATH</h1>
        <p class="subtitle">Edit Volunteer</p>
        <?php include "admin_nav.php"; ?>
        <?php if ($message !== "") { ?><div class="success"><?php echo $message; ?></div><?php } ?>
        <section class="panel">
            <h2>Volunteer Detail</h2>
            <?php if ($volunteer) { ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="v_id" value="<?php echo $volunteerId; ?>">
                <div class="row"><label>V_ID</label><input type="text" value="<?php echo $volunteerId; ?>" readonly></div>
                <div class="row"><label>First Name</label><input type="text" name="first_name" value="<?php echo $volunteer["first_name"]; ?>"></div>
                <div class="row"><label>Last Name</label><input type="text" name="last_name" value="<?php echo $volunteer["last_name"]; ?>"></div>
                <div class="row"><label>Email</label><input type="email" name="email" value="<?php echo $volunteer["email"]; ?>"></div>
                <div class="row"><label>Phone</label><input type="text" name="phone" value="<?php echo $volunteer["phone"]; ?>"></div>
                <div class="row"><label>Car Model</label><input type="text" name="car_model" value="<?php echo $volunteer["car_model"]; ?>"></div>
                <div class="row"><label>Car Year</label><input type="text" name="car_year" value="<?php echo $volunteer["car_year"]; ?>"></div>
                <div class="actions"><input type="submit" value="Update Volunteer"></div>
            </form>
            <?php } ?>
        </section>
    </div></div></div>
</body>
</html>
