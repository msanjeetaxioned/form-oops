<?php

class Login 
{
    public static $rememberMe = false;
    public static $loginEmail;
    public static $loginPassword;
    
    public static function onSubmit() 
    {
        self::$loginEmail = $_POST["login-email"];
        self::$loginPassword = $_POST["login-password"];

        if(isset($_POST["remember-me"])) {
            self::$rememberMe = true;
        }
        Validation::loginEmailAndPasswordValidation(self::$loginEmail, self::$loginPassword);
        if(Validation::$loginError == "") {
            if(self::$rememberMe) {
                setcookie("email", self::$loginEmail, time() + 365 * 24 * 60 * 60, "/", "", 0);
            }
            else {
                setcookie("email", self::$loginEmail, 0, "/", "", 0);
            }
            header('Location: http://localhost/php/form-oops/users.php');
        }
    }
}