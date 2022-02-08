<?php
// After Successful form submit show message and submitted data to User.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->onSubmit();
}