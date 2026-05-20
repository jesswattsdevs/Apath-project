<?php
include "helpers.php";
include "connection.php";
require_login(array(2));

$currentPage = "profile";
$studentId = (int) $_SESSION["user_id"];
$firstName = "";
$lastName = "";
$gender = "";
$email = "";
$phone = "";
$major = "";
$classification = "";
$bringingFamily = "";
$studentStatus = "";
$schoolGraduatedFrom = "";
$emergencyPhone = "";
$covidVaccine = "";
$specialAttention = "";
$comment = "";
$adminComment = "";

$firstNameErr = "";
$lastNameErr = "";
$genderErr = "";
$emailErr = "";
$phoneErr = "";
$majorErr = "";
$classificationErr = "";
$bringingFamilyErr = "";
$studentStatusErr = "";
$schoolGraduatedFromErr = "";
$emergencyPhoneErr = "";
$covidVaccineErr = "";
$specialAttentionErr = "";
$successMessage = "";

$loadSql = "SELECT * FROM apath_student WHERE s_id=$studentId";
$loadResult = mysqli_query($dbc, $loadSql);
if ($loadResult && mysqli_num_rows($loadResult) === 1) {
    $row = mysqli_fetch_assoc($loadResult);
    $firstName = $row["first_name"];
    $lastName = $row["last_name"];
    $gender = $row["gender"];
    $email = $row["email"] !== "" ? $row["email"] : $_SESSION["user_email"];
    $phone = $row["phone"];
    $major = $row["major"];
    $classification = $row["classification"];
    $bringingFamily = $row["bringing_family"];
    $studentStatus = $row["student_status"];
    $schoolGraduatedFrom = $row["school_graduated_from"];
    $emergencyPhone = $row["emergency_phone"];
    $covidVaccine = $row["covid_vaccine"];
    $specialAttention = $row["special_attention"];
    $comment = $row["student_comment"];
    $adminComment = $row["admin_comment"];
} else {
    $email = $_SESSION["user_email"];
}

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $firstName = test_input($_POST["first_name"] ?? "");
    $lastName = test_input($_POST["last_name"] ?? "");
    $gender = $_POST["gender"] ?? "";
    $email = test_input($_POST["email"] ?? "");
    $phone = test_input($_POST["phone"] ?? "");
    $major = test_input($_POST["major"] ?? "");
    $classification = $_POST["classification"] ?? "";
    $bringingFamily = $_POST["bringing_family"] ?? "";
    $studentStatus = $_POST["student_status"] ?? "";
    $schoolGraduatedFrom = test_input($_POST["school_graduated_from"] ?? "");
    $emergencyPhone = test_input($_POST["emergency_phone"] ?? "");
    $covidVaccine = $_POST["covid_vaccine"] ?? "";
    $specialAttention = $_POST["special_attention"] ?? "";
    $comment = test_input($_POST["comment"] ?? "");
    $adminComment = test_input($_POST["admin_comment"] ?? "");
    $hasError = false;

    if ($firstName === "") {
        $firstNameErr = "First name is required.";
        $hasError = true;
    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $firstName)) {
        $firstNameErr = "Use letters only.";
        $hasError = true;
    }

    if ($lastName === "") {
        $lastNameErr = "Last name is required.";
        $hasError = true;
    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $lastName)) {
        $lastNameErr = "Use letters only.";
        $hasError = true;
    }

    if ($gender === "") {
        $genderErr = "Gender is required.";
        $hasError = true;
    }

    if ($email === "") {
        $emailErr = "Email is required.";
        $hasError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
        $hasError = true;
    }

    if ($phone === "") {
        $phoneErr = "Phone is required.";
        $hasError = true;
    } elseif (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
        $phoneErr = "Use ###-###-#### format.";
        $hasError = true;
    }

    if ($major === "") {
        $majorErr = "Major is required.";
        $hasError = true;
    }

    if ($classification === "") {
        $classificationErr = "Classification is required.";
        $hasError = true;
    }

    if ($bringingFamily === "") {
        $bringingFamilyErr = "Please choose yes or no.";
        $hasError = true;
    }

    if ($studentStatus === "") {
        $studentStatusErr = "Please choose returning or first time.";
        $hasError = true;
    }

    if ($schoolGraduatedFrom === "") {
        $schoolGraduatedFromErr = "School graduated from is required.";
        $hasError = true;
    }

    if ($emergencyPhone === "") {
        $emergencyPhoneErr = "Emergency phone is required.";
        $hasError = true;
    } elseif (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $emergencyPhone)) {
        $emergencyPhoneErr = "Use ###-###-#### format.";
        $hasError = true;
    }

    if ($covidVaccine === "") {
        $covidVaccineErr = "Please choose yes or no.";
        $hasError = true;
    }

    if ($specialAttention === "") {
        $specialAttentionErr = "Please choose yes or no.";
        $hasError = true;
    }

    if (!$hasError) {
        $safeEmail = mysqli_real_escape_string($dbc, $email);
        $safeFirstName = mysqli_real_escape_string($dbc, $firstName);
        $safeLastName = mysqli_real_escape_string($dbc, $lastName);
        $safeGender = mysqli_real_escape_string($dbc, $gender);
        $safePhone = mysqli_real_escape_string($dbc, $phone);
        $safeMajor = mysqli_real_escape_string($dbc, $major);
        $safeClassification = mysqli_real_escape_string($dbc, $classification);
        $safeBringingFamily = mysqli_real_escape_string($dbc, $bringingFamily);
        $safeStudentStatus = mysqli_real_escape_string($dbc, $studentStatus);
        $safeSchool = mysqli_real_escape_string($dbc, $schoolGraduatedFrom);
        $safeEmergencyPhone = mysqli_real_escape_string($dbc, $emergencyPhone);
        $safeCovid = mysqli_real_escape_string($dbc, $covidVaccine);
        $safeSpecialAttention = mysqli_real_escape_string($dbc, $specialAttention);
        $safeComment = mysqli_real_escape_string($dbc, $comment);
        $safeAdminComment = mysqli_real_escape_string($dbc, $adminComment);

        mysqli_query($dbc, "UPDATE apath_users SET email='$safeEmail' WHERE id=$studentId");
        $saveSql = "INSERT INTO apath_student (s_id, email, first_name, last_name, gender, phone, major, classification, bringing_family, student_status, school_graduated_from, emergency_phone, covid_vaccine, special_attention, student_comment, admin_comment)
                    VALUES ($studentId, '$safeEmail', '$safeFirstName', '$safeLastName', '$safeGender', '$safePhone', '$safeMajor', '$safeClassification', '$safeBringingFamily', '$safeStudentStatus', '$safeSchool', '$safeEmergencyPhone', '$safeCovid', '$safeSpecialAttention', '$safeComment', '$safeAdminComment')
                    ON DUPLICATE KEY UPDATE
                    email='$safeEmail', first_name='$safeFirstName', last_name='$safeLastName', gender='$safeGender', phone='$safePhone', major='$safeMajor',
                    classification='$safeClassification', bringing_family='$safeBringingFamily', student_status='$safeStudentStatus', school_graduated_from='$safeSchool',
                    emergency_phone='$safeEmergencyPhone', covid_vaccine='$safeCovid', special_attention='$safeSpecialAttention', student_comment='$safeComment',
                    admin_comment='$safeAdminComment'";
        mysqli_query($dbc, $saveSql);
        $successMessage = "Personal profile submitted successfully.";
    }
}
?>
<html>
<head>
    <title>Lab 7 - Student Personal Profile</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Student Personal Profile</p>
                <?php include "student_nav.php"; ?>
                <?php if ($successMessage !== "") { ?><div class="success"><?php echo $successMessage; ?></div><?php } ?>
                <section class="panel">
                    <h2>Profile Form</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>">
                            <?php if ($firstNameErr !== "") { ?><div class="error"><?php echo $firstNameErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="last_name">Last Name <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>">
                            <?php if ($lastNameErr !== "") { ?><div class="error"><?php echo $lastNameErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label>Gender <span class="required">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="gender" value="Male" <?php if ($gender === "Male") echo "checked"; ?>> Male</label>
                                <label><input type="radio" name="gender" value="Female" <?php if ($gender === "Female") echo "checked"; ?>> Female</label>
                                <label><input type="radio" name="gender" value="Other" <?php if ($gender === "Other") echo "checked"; ?>> Other</label>
                            </div>
                            <?php if ($genderErr !== "") { ?><div class="error"><?php echo $genderErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                            <?php if ($emailErr !== "") { ?><div class="error"><?php echo $emailErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="phone">Phone <span class="required">*</span></label>
                            <input type="text" id="phone" name="phone" placeholder="123-456-7890" value="<?php echo $phone; ?>">
                            <?php if ($phoneErr !== "") { ?><div class="error"><?php echo $phoneErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="major">Major <span class="required">*</span></label>
                            <input type="text" id="major" name="major" value="<?php echo $major; ?>">
                            <?php if ($majorErr !== "") { ?><div class="error"><?php echo $majorErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="classification">Classification <span class="required">*</span></label>
                            <select id="classification" name="classification">
                                <option value="">Select classification</option>
                                <option value="Freshman" <?php if ($classification === "Freshman") echo "selected"; ?>>Freshman</option>
                                <option value="Sophomore" <?php if ($classification === "Sophomore") echo "selected"; ?>>Sophomore</option>
                                <option value="Junior" <?php if ($classification === "Junior") echo "selected"; ?>>Junior</option>
                                <option value="Senior" <?php if ($classification === "Senior") echo "selected"; ?>>Senior</option>
                                <option value="Graduate" <?php if ($classification === "Graduate") echo "selected"; ?>>Graduate</option>
                            </select>
                            <?php if ($classificationErr !== "") { ?><div class="error"><?php echo $classificationErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label>Bringing Family Members? <span class="required">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="bringing_family" value="Yes" <?php if ($bringingFamily === "Yes") echo "checked"; ?>> Yes</label>
                                <label><input type="radio" name="bringing_family" value="No" <?php if ($bringingFamily === "No") echo "checked"; ?>> No</label>
                            </div>
                            <?php if ($bringingFamilyErr !== "") { ?><div class="error"><?php echo $bringingFamilyErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label>Returning or First Time Student? <span class="required">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="student_status" value="Returning" <?php if ($studentStatus === "Returning") echo "checked"; ?>> Returning</label>
                                <label><input type="radio" name="student_status" value="FirstTime" <?php if ($studentStatus === "FirstTime") echo "checked"; ?>> First Time</label>
                            </div>
                            <?php if ($studentStatusErr !== "") { ?><div class="error"><?php echo $studentStatusErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="school_graduated_from">School Graduated From <span class="required">*</span></label>
                            <input type="text" id="school_graduated_from" name="school_graduated_from" value="<?php echo $schoolGraduatedFrom; ?>">
                            <?php if ($schoolGraduatedFromErr !== "") { ?><div class="error"><?php echo $schoolGraduatedFromErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="emergency_phone">Phone In Case Of Emergency <span class="required">*</span></label>
                            <input type="text" id="emergency_phone" name="emergency_phone" placeholder="123-456-7890" value="<?php echo $emergencyPhone; ?>">
                            <?php if ($emergencyPhoneErr !== "") { ?><div class="error"><?php echo $emergencyPhoneErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label>Did You Already Get COVID Vaccine? <span class="required">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="covid_vaccine" value="Yes" <?php if ($covidVaccine === "Yes") echo "checked"; ?>> Yes</label>
                                <label><input type="radio" name="covid_vaccine" value="No" <?php if ($covidVaccine === "No") echo "checked"; ?>> No</label>
                            </div>
                            <?php if ($covidVaccineErr !== "") { ?><div class="error"><?php echo $covidVaccineErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label>Special Attention? <span class="required">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="special_attention" value="Yes" <?php if ($specialAttention === "Yes") echo "checked"; ?>> Yes</label>
                                <label><input type="radio" name="special_attention" value="No" <?php if ($specialAttention === "No") echo "checked"; ?>> No</label>
                            </div>
                            <?php if ($specialAttentionErr !== "") { ?><div class="error"><?php echo $specialAttentionErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="comment">Any Comment</label>
                            <textarea id="comment" name="comment"><?php echo $comment; ?></textarea>
                        </div>

                        <div class="row">
                            <label for="admin_comment">Admin Comment</label>
                            <textarea id="admin_comment" name="admin_comment"><?php echo $adminComment; ?></textarea>
                        </div>

                        <div class="actions">
                            <input type="submit" value="Submit Personal Profile">
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
