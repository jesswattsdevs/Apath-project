<?php
include "helpers.php";
include "connection.php";

$email = "";
$pw = "";
$confirmPw = "";
$type = "2";
$emailErr = "";
$pwErr = "";
$confirmPwErr = "";
$typeErr = "";
$message = "";

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $email = test_input($_POST["email"] ?? "");
    $pw = test_input($_POST["pw"] ?? "");
    $confirmPw = test_input($_POST["confirm_pw"] ?? "");
    $type = $_POST["type"] ?? "2";
    $hasError = false;

    if ($email === "") {
        $emailErr = "Email is required.";
        $hasError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
        $hasError = true;
    }

    if ($pw === "") {
        $pwErr = "Password is required.";
        $hasError = true;
    }

    if ($confirmPw === "") {
        $confirmPwErr = "Please confirm password.";
        $hasError = true;
    } elseif ($pw !== $confirmPw) {
        $confirmPwErr = "Passwords do not match.";
        $hasError = true;
    }

    if ($type !== "1" && $type !== "2") {
        $typeErr = "Please choose a role.";
        $hasError = true;
    }

    if (!$hasError) {
        $safeEmail = mysqli_real_escape_string($dbc, $email);
        $safePw = mysqli_real_escape_string($dbc, $pw);
        $safeType = (int) $type;

        $check = mysqli_query($dbc, "SELECT id FROM apath_users WHERE email='$safeEmail'");
        if ($check && mysqli_num_rows($check) > 0) {
            $emailErr = "Email is already used.";
        } else {
            $insert = "INSERT INTO apath_users (email, pw, type) VALUES ('$safeEmail', '$safePw', $safeType)";
            mysqli_query($dbc, $insert);
            $newId = mysqli_insert_id($dbc);

            if ($safeType === 2) {
                upsert_student_shell($dbc, $newId, $email);
            } else {
                upsert_volunteer_shell($dbc, $newId, $email);
            }

            $message = "Registration successful. You can now log in.";
            $email = "";
            $pw = "";
            $confirmPw = "";
            $type = "2";
        }
    }
}
?>
<html>
<head>
    <title>APATH Registration</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">I'm an international student that needs help</p>
                <section class="panel">
                    <h2>Registration</h2>
                    <?php if ($message !== "") { ?><div class="success"><?php echo $message; ?></div><?php } ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                            <?php if ($emailErr !== "") { ?><div class="error"><?php echo $emailErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="pw">Password <span class="required">*</span></label>
                            <input type="password" id="pw" name="pw" value="<?php echo $pw; ?>">
                            <?php if ($pwErr !== "") { ?><div class="error"><?php echo $pwErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="confirm_pw">Confirm Password <span class="required">*</span></label>
                            <input type="password" id="confirm_pw" name="confirm_pw" value="<?php echo $confirmPw; ?>">
                            <?php if ($confirmPwErr !== "") { ?><div class="error"><?php echo $confirmPwErr; ?></div><?php } ?>
                        </div>

                        <div class="row">
                            <label for="type">Register As <span class="required">*</span></label>
                            <select id="type" name="type">
                                <option value="2" <?php if ($type === "2") echo "selected"; ?>>Student</option>
                                <option value="1" <?php if ($type === "1") echo "selected"; ?>>Volunteer</option>
                            </select>
                            <?php if ($typeErr !== "") { ?><div class="error"><?php echo $typeErr; ?></div><?php } ?>
                        </div>

                        <div class="actions">
                            <input type="submit" value="Register">
                        </div>
                    </form>
                    <p><a href="index.php">Back to login</a></p>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
