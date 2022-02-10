<?php
if(isset($_COOKIE["user-data"])) {
    $submittedData = json_decode($_COOKIE["user-data"], true);
    $name = $submittedData['name'];
    $email = $submittedData['email'];
    $gender = $submittedData['gender'];
    $mobile = $submittedData['mobile'];
    $filename = $submittedData['file'];
}

if(isset($_COOKIE["update"])) {
    // Update Email in Cookie
    setcookie("email", $email, time() + 365 * 24 * 60 * 60, "/", "", 0);
    // Delete 'Update' Cookie after successfull Update of DB
    setcookie("update", "", time() - 300, "/", "", 0);
    setcookie("user-data", "", time() - 300, "/", "", 0);
}