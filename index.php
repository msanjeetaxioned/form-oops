<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_COOKIE["update"]) ? "Update User" : "Register User"; ?></title>
    <link rel="stylesheet" href="css/override.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
<?php
require('utility/errors.php');
require('utility/db-connection.php');
require('utility/update-user.php');
require('utility/validation.php');
require('utility/register-user.php');
require('utility/form-validation.php');
?>
    <div class="wrapper">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <h1><?php echo isset($_COOKIE["update"]) ? "Update User" : "Register User"; ?></h1>
            <p class="note">Note: All of the below fields are Required.</p>
            <div class="name-div percent-50">
                <input type="text" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ''; ?>">
                <span class="error-message"><?php echo Validation::$nameError; ?></span>
            </div>
            <div class="email-div percent-50">
                <input type="email" name="email" placeholder="Email Id" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
                <span class="error-message"><?php echo Validation::$emailError; ?></span>
            </div>
            <div class="mobile-div percent-50">
                <input type="tel" name="phone-num" placeholder="Mobile Number" value="<?php echo isset($_POST['phone-num']) ? htmlspecialchars($_POST['phone-num'], ENT_QUOTES) : ''; ?>">
                <span class="error-message"><?php echo Validation::$mobileNumError; ?></span>
            </div>
            <div class="gender-div percent-50">
                <div class="gender-radio">
                    <h3>Gender:</h3>
                    <label for="male">Male</label>
                    <input type="radio" id="male" name="gender" value="Male" <?php echo (isset($_POST['gender'])) ? (($_POST['gender'] === 'Male') ? 'checked' : '') : ''; ?>>
                    <label for="female">Female</label>
                    <input type="radio" id="female" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?>>
                </div>
                <span class="error-message"><?php echo Validation::$genderError; ?></span>
            </div>
            <div class="password-div percent-50">
                <input type="password" name="password" placeholder="Password">
                <span class="<?php echo isset($_POST['password']) ? 'error-message' : 'error-message hint'?>"><?php echo Validation::$passwordError; ?></span>
            </div>
            <div class="confirm-password-div percent-50">
                <input type="password" name="confirm-password" placeholder="Confirm Password">
                <span class="error-message"><?php echo Validation::$confirmPassError; ?></span>
            </div>
            <div class="file-div percent-50">
                <input type="file" name="file">
                <span class="error-message"><?php echo Validation::$fileError; ?></span>
            </div>
            <div class="submit-div">
                <button type="submit">submit</button>
            </div>
        </form>
        <?php
        require('utility/form-submit.php');
        ?>
    </div>
    <script>
    // To prevent Page Refresh from Submitting Form
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>
</html>