<?php

class ErrorMessages 
{
    public static $emptyErrors = ["name" => "*Please enter your Name!", "email" => "*Please enter your Email Address!", "mobile-num" => "*Please enter your Mobile Number!", "gender" => "*Please select your Gender!", "password" => "*Please enter a Password!", "confirm-pass" => "*Please confirm your Password!", "file" => "*Please Upload your picture!"];

    public static $criteriaErrors = ["name" => "*Please enter a valid Name!", "email" => "*Please enter a valid Email Address!", "mobile-num" => "*Please enter a valid Mobile Number!", "password" => "*Password must have minimum 8 characters. It must contain 1 Uppercase Character, 1 Number & 1 Special Character.", "confirm-pass" => "*Password entered here should match the above Password."];

    public static $fileErrors = ["type" => "*Sorry, only Image(JPG, JPEG & PNG) files are allowed.", "name" => "*Sorry, file already exists. Try a different name.", "size" => "*Sorry, your file is too large. Max. allowed size <=1.5mb.", "other" => "*Sorry, some Unknown Error Occured."];

    public static $fromDatabaseErrors = ["email" => "*Email Address is already in use. Please use another."];

    public static $loginErrorMessage = "*Invalid Email ID and/or Password";
}