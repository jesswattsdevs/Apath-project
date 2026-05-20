<?php
$currentPage = "housing";
$needsTempHousing = "";
$housingDays = "";
$specialNotes = "";

$needsTempHousingErr = "";
$housingDaysErr = "";
$successMessage = "";

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $needsTempHousing = $_POST["needs_temp_housing"] ?? "";
    $housingDays = test_input($_POST["housing_days"] ?? "");
    $specialNotes = test_input($_POST["special_notes"] ?? "");
    $hasError = false;

    if ($needsTempHousing === "") {
        $needsTempHousingErr = "Please choose yes or no.";
        $hasError = true;
    }

    if ($needsTempHousing === "Yes" && $housingDays === "") {
        $housingDaysErr = "Please enter the number of days.";
        $hasError = true;
    }

    if (!$hasError) {
        $successMessage = "Temporary housing request submitted successfully.";
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<html>
<head>
    <title>Lab 7 - Temp Housing Need</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Student Temp Housing Need</p>
                <?php include "student_nav.php"; ?>
                <?php if ($successMessage !== "") { ?><div class="success"><?php echo $successMessage; ?></div><?php } ?>
                <section class="panel">
                    <h2>Temporary Housing Form</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <label>Need Temporary Housing? <span class="required">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="needs_temp_housing" value="Yes" <?php if ($needsTempHousing === "Yes") echo "checked"; ?>> Yes</label>
                                <label><input type="radio" name="needs_temp_housing" value="No" <?php if ($needsTempHousing === "No") echo "checked"; ?>> No</label>
                            </div>
                            <?php if ($needsTempHousingErr !== "") { ?><div class="error"><?php echo $needsTempHousingErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="housing_days">How Many Days?</label>
                            <input type="text" id="housing_days" name="housing_days" value="<?php echo $housingDays; ?>">
                            <?php if ($housingDaysErr !== "") { ?><div class="error"><?php echo $housingDaysErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="special_notes">Special Notes</label>
                            <textarea id="special_notes" name="special_notes"><?php echo $specialNotes; ?></textarea>
                        </div>

                        <div class="actions">
                            <input type="submit" value="Submit Temp Housing Need">
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
