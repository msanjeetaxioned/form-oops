<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Response</title>
    <link rel="stylesheet" href="css/override.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/submit.css">
</head>
<body>
    <?php
    require('utility/submit-response.php');
    ?>
    <div class='wrapper'>
        <div class="submitted-data">
            <?php
            if(isset($_COOKIE["update"])) {
            ?>
            <h2>User '<?php echo $_COOKIE["update"]; ?>' Updated!</h2>
            <?php
            } else {
            ?>
            <h2>User Registered Successfully!</h2>
            <?php 
            } ?>
            <h3>Submitted Data:</h3>
            <p><small>Name: </small><?php echo $name; ?></p>
            <p><small>Mobile Number: </small><?php echo $mobile; ?></p>
            <p><small>Gender: </small><?php echo $gender; ?></p>
            <p><small>Uploaded Image:</small></p>
            <figure><img src='image-upload/<?php echo $filename; ?>' alt='Your Profile Picture'></figure>
        </div>
        <div class="login-div">
            <h2>Login Page</h2>
            <a href="http://localhost/php/form-oops/login.php" title="Login">Login</a>
        </div>
    </div>
</body>
</html>