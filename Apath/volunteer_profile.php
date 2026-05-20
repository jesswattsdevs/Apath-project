<?php
include "helpers.php";
include "connection.php";
require_login(array(1));

$currentPage = "profile";
$volunteerId = (int) $_SESSION["user_id"];
$email = $_SESSION["user_email"];
$firstName = "";
$lastName = "";
$phone = "";
$gender = "";
$occupation = "";
$affiliation = "";
$wechat = "";
$covidVaccine = "";
$specialNote = "";
$message = "";

$sql = "SELECT * FROM apath_volunteer WHERE v_id=$volunteerId";
$result = mysqli_query($dbc, $sql);
if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row["first_name"];
    $lastName = $row["last_name"];
    $phone = $row["phone"];
    $gender = $row["gender"];
    $occupation = $row["occupation"];
    $affiliation = $row["affiliation"];
    $wechat = $row["wechat"];
    $covidVaccine = $row["covid_vaccine"];
    $specialNote = $row["special_note"];
    if ($row["email"] !== "") {
        $email = $row["email"];
    }
}

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $firstName = test_input($_POST["first_name"] ?? "");
    $lastName = test_input($_POST["last_name"] ?? "");
    $email = test_input($_POST["email"] ?? "");
    $phone = test_input($_POST["phone"] ?? "");
    $gender = $_POST["gender"] ?? "";
    $occupation = test_input($_POST["occupation"] ?? "");
    $affiliation = test_input($_POST["affiliation"] ?? "");
    $wechat = test_input($_POST["wechat"] ?? "");
    $covidVaccine = $_POST["covid_vaccine"] ?? "";
    $specialNote = test_input($_POST["special_note"] ?? "");

    $safeFirstName = mysqli_real_escape_string($dbc, $firstName);
    $safeLastName = mysqli_real_escape_string($dbc, $lastName);
    $safeEmail = mysqli_real_escape_string($dbc, $email);
    $safePhone = mysqli_real_escape_string($dbc, $phone);
    $safeGender = mysqli_real_escape_string($dbc, $gender);
    $safeOccupation = mysqli_real_escape_string($dbc, $occupation);
    $safeAffiliation = mysqli_real_escape_string($dbc, $affiliation);
    $safeWechat = mysqli_real_escape_string($dbc, $wechat);
    $safeCovid = mysqli_real_escape_string($dbc, $covidVaccine);
    $safeNote = mysqli_real_escape_string($dbc, $specialNote);

    $save = "INSERT INTO apath_volunteer (v_id, first_name, last_name, email, phone, gender, occupation, affiliation, wechat, covid_vaccine, special_note)
             VALUES ($volunteerId, '$safeFirstName', '$safeLastName', '$safeEmail', '$safePhone', '$safeGender', '$safeOccupation', '$safeAffiliation', '$safeWechat', '$safeCovid', '$safeNote')
             ON DUPLICATE KEY UPDATE
             first_name='$safeFirstName', last_name='$safeLastName', email='$safeEmail', phone='$safePhone', gender='$safeGender',
             occupation='$safeOccupation', affiliation='$safeAffiliation', wechat='$safeWechat', covid_vaccine='$safeCovid', special_note='$safeNote'";
    mysqli_query($dbc, $save);
    $message = "Volunteer profile saved successfully.";
}
?>
<html>
<head>
    <title>Volunteer Profile</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Volunteer Personal Profile</p>
                <?php include "volunteer_nav.php"; ?>
                <?php if ($message !== "") { ?><div class="success"><?php echo $message; ?></div><?php } ?>
                <section class="panel">
                    <h2>Volunteer Profile</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row"><label for="first_name">First Name</label><input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>"></div>
                        <div class="row"><label for="last_name">Last Name</label><input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>"></div>
                        <div class="row"><label for="email">Email</label><input type="email" id="email" name="email" value="<?php echo $email; ?>"></div>
                        <div class="row"><label for="phone">Phone</label><input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"></div>
                        <div class="row">
                            <label>Gender</label>
                            <div class="radio-group">
                                <label><input type="radio" name="gender" value="Male" <?php if ($gender === "Male") echo "checked"; ?>> Male</label>
                                <label><input type="radio" name="gender" value="Female" <?php if ($gender === "Female") echo "checked"; ?>> Female</label>
                                <label><input type="radio" name="gender" value="Other" <?php if ($gender === "Other") echo "checked"; ?>> Other</label>
                            </div>
                        </div>
                        <div class="row"><label for="occupation">Occupation</label><input type="text" id="occupation" name="occupation" value="<?php echo $occupation; ?>"></div>
                        <div class="row"><label for="affiliation">Affiliation</label><input type="text" id="affiliation" name="affiliation" value="<?php echo $affiliation; ?>"></div>
                        <div class="row"><label for="wechat">WeChat</label><input type="text" id="wechat" name="wechat" value="<?php echo $wechat; ?>"></div>
                        <div class="row">
                            <label>COVID Vaccine</label>
                            <div class="radio-group">
                                <label><input type="radio" name="covid_vaccine" value="Yes" <?php if ($covidVaccine === "Yes") echo "checked"; ?>> Yes</label>
                                <label><input type="radio" name="covid_vaccine" value="No" <?php if ($covidVaccine === "No") echo "checked"; ?>> No</label>
                            </div>
                        </div>
                        <div class="row"><label for="special_note">Special Note</label><textarea id="special_note" name="special_note"><?php echo $specialNote; ?></textarea></div>
                        <div class="actions"><input type="submit" value="Save Volunteer Profile"></div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
