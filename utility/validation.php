<?php

class Validation 
{
    static $nameError = "";
    static $emailError = "";
    static $mobileNumError = "";
    static $genderError = "";
    static $passwordError = "Hint: Password must have minimum 8 characters. It must contain 1 Uppercase Character, 1 Number & 1 Special Character.";
    static $confirmPassError = "";
    static $fileError = "";
    static $loginError = "";

    public static function nameValidation($name) 
    {
        if (empty($name)) {
            self::$nameError = ErrorMessages::$emptyErrors["name"];
        } elseif (strlen($name) >= 2) {
            $pattern = "/^[a-z ,.'-]+$/i";
            if (preg_match($pattern, $name)) {
                self::$nameError = "";
            } else {
                self::$nameError = ErrorMessages::$criteriaErrors["name"];
            }
        }
    }

    public static function emailValidation($email) 
    {
        if (empty($email)) {
            self::$emailError = ErrorMessages::$emptyErrors["email"];
        } else {
            $pattern = "/(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            if (preg_match($pattern, $email)) {
                self::$emailError = "";
            } else {
                self::$emailError = ErrorMessages::$criteriaErrors["email"];
            }
        }
    }

    public static function checkIfEmailAlreadyUsedInDB($email) 
    {
        DatabaseConnection::startConnection();
        if(isset($_COOKIE["update"])) {
            $updateEmail = $_COOKIE["update"];
            $select = mysqli_query(DatabaseConnection::$conn, "SELECT * FROM users WHERE email = '$email' AND email <> '$updateEmail'");
        } else { 
            $select = mysqli_query(DatabaseConnection::$conn, "SELECT * FROM users WHERE email = '$email'");
        }

        if(mysqli_num_rows($select)) {
            self::$emailError = ErrorMessages::$fromDatabaseErrors["email"];
        } else {
            self::$emailError = "";
        }
        DatabaseConnection::closeDBConnection();
    }
    
    public static function mobileNumValidation($mobileNum) 
    {
        if (empty($mobileNum)) {
            self::$mobileNumError = ErrorMessages::$emptyErrors["mobile-num"];
        } else {
            $pattern = "/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/";
            if (preg_match($pattern, $mobileNum)) {
                self::$mobileNumError = "";
            }
            else {
                self::$mobileNumError = ErrorMessages::$criteriaErrors["mobile-num"];
            }
        }
    }
    
    public static function genderValidation($gender) 
    {
        if ($gender == "") {
            self::$genderError = ErrorMessages::$emptyErrors["gender"];
        } else {
            self::$genderError = "";
        }
    }
    
    public static function passwordValidation($password) 
    {
        if (empty($password)) {
            self::$passwordError = ErrorMessages::$emptyErrors["password"];
        } else {
            $pattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
            if (preg_match($pattern, $password)) {
                self::$passwordError = "";
            }
            else {
                self::$passwordError = ErrorMessages::$criteriaErrors["password"];
            }
        }
    }
    
    public static function confirmPasswordValidation($password, $confirmPass) 
    {
        if (empty($confirmPass)) {
            self::$confirmPassError = ErrorMessages::$emptyErrors["confirm-pass"];
        } else {
            if ($confirmPass == $password) {
                self::$confirmPassError = "";
            }
            else {
                self::$confirmPassError = ErrorMessages::$criteriaErrors["confirm-pass"];
            }
        }
    }
    
    public static function fileValidation($file) 
    {
        if (empty($file["name"])) {
            self::$fileError = ErrorMessages::$emptyErrors["file"];
            return;
        }
        $target_dir = "image-upload/";
        $target_file = $target_dir.basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Check if image file is a actual image of required types
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            self::$fileError =  ErrorMessages::$fileErrors["type"];
            return;
        }
    
        // Check if file with same name is already stored
        if (file_exists($target_file)) {
            self::$fileError =  ErrorMessages::$fileErrors["name"];
            return;
        }
    
        // max. upload file size allowed is 1.5MB
        if ($file["size"] > 1500000) {
            self::$fileError =  ErrorMessages::$fileErrors["size"];
            return;
        }
    
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            chmod($target_file, 0750);
            self::$fileError = "";
            return;
        } else {
            self::$fileError = ErrorMessages::$fileErrors["other"];
            return;
        }
    }

    public static function loginEmailAndPasswordValidation($email, $password) 
    {
        DatabaseConnection::startConnection();
        $password = hash('sha512', $password);
        $select = mysqli_query(DatabaseConnection::$conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password';");
        if(mysqli_num_rows($select)) {
            self::$loginError = "";
        } else {
            self::$loginError = ErrorMessages::$loginErrorMessage;
        }
        DatabaseConnection::closeDBConnection();
    }

    public static function checkIfAllFieldsAreValid() 
    {
        $arr = [self:$nameError, self:$emailError, self:$mobileNumError, self:$genderError, self:$passwordError, self:$confirmPassError, self:$fileError];

        for($i = 0; $i < count($arr); $i++) {
            if($arr[$i] != "") {
                return false;
            }
        }
        return true;
    }
}