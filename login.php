<?php
if(isset($_COOKIE["email"])) {
    header('Location: http://localhost/php/form-oops/users.php');
}
require('utility/errors.php');
require('utility/db-connection.php');
require('utility/validation.php');
require('utility/login-class.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    Login::onSubmit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/override.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="wrapper">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <h1>Login Page</h1>
            <input type="email" name="login-email" placeholder="Email Id" value="<?php echo isset($_POST['login-email']) ? htmlspecialchars($_POST['login-email'], ENT_QUOTES) : ''; ?>">
            <input type="password" name="login-password" placeholder="Password">
            <span class='error-message <?php echo isset($_POST['login-email']) ? "" : "display-none" ?>'><?php echo Validation::$loginError; ?></span>
            <div class="remember-me-div">
                <input id="remember-me-checkbox" type="checkbox" name="remember-me" value="remember-me">
                <label for="remember-me-checkbox">Remember Me</label>
            </div>
            <div class="submit-div">
                <button type="submit">submit</button>
            </div>
        </form>
        <div class="login-div">
            <h2>New User? Register Below</h2>
            <a href="http://localhost/php/form-oops/" title="Register">Register</a>
        </div>
    </div>
    <script>
    // To prevent Page Refresh from Submitting Form
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>
</html>