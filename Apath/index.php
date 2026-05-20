<?php
include "helpers.php";
include "connection.php";

$email = "";
$pw = "";
$message = "";

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $email = test_input($_POST["email"] ?? "");
    $pw = test_input($_POST["pw"] ?? "");

    $safeEmail = mysqli_real_escape_string($dbc, $email);
    $sql = "SELECT * FROM apath_users WHERE email='$safeEmail'";
    $result = mysqli_query($dbc, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($pw === $row["pw"]) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            $_SESSION["user_type"] = (int) $row["type"];
            redirect_to_home($_SESSION["user_type"]);
        } else {
            $message = "Password is incorrect. Try again.";
        }
    } else {
        $message = "Email not found. Please register.";
    }
}
?>
<html>
<head>
    <title>APATH Login</title>
    <?php include "student_styles.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="hero">
            <div class="hero-inner">
                <h1>APATH</h1>
                <p class="subtitle">Login Page</p>
                <section class="panel">
                    <h2>Welcome</h2>
                    <p>If you already have an account, log in below.</p>
                    <p>If you do not have an account, please <a href="registration.php">register here</a>.</p>
                    <p><a href="about.php">About APATH</a> | <a href="contact.php">Contact</a></p>
                    <?php if ($message !== "") { ?><div class="success error-box"><?php echo $message; ?></div><?php } ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="row">
                            <label for="pw">Password</label>
                            <input type="password" id="pw" name="pw" value="<?php echo $pw; ?>">
                        </div>
                        <div class="actions">
                            <input type="submit" value="Login">
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
