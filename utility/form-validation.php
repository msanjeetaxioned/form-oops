<?php
// Check if form submitted with 'POST' method
$user = new RegisterUser();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->validateFields();
}