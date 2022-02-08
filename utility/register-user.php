<?php

class RegisterUser {
    public $name;

    public $email;

    public $mobileNum;

    public $gender;

    public $password;

    public $confirmPass;

    public $file;

    public function validateFields() {
        // Name Validation
        $this->name = $_POST["name"];
        Validation::nameValidation($this->name);

        // Email Validation
        $this->email = $_POST["email"];
        Validation::emailValidation($this->email);
        if(Validation::$emailError == "") {
            Validation::checkIfEmailAlreadyUsedInDB($this->email);
        }

        // Mobile Number Validation
        $this->mobileNum = $_POST["phone-num"];
        Validation::mobileNumValidation($this->mobileNum);

        // Get Gender
        if(isset($_POST["gender"])) {
            $this->gender = $_POST["gender"];
        } else {
            $this->gender = "";
        }
        Validation::genderValidation($this->gender);

        // Password Validation
        $this->password = $_POST["password"];
        Validation::passwordValidation($this->password);

        // Confirm Password Validation
        $this->confirmPass = $_POST["confirm-password"];
        Validation::confirmPasswordValidation($this->password, $this->confirmPass);

        // Image submitted Validation
        $this->file = $_FILES["file"];
        Validation::fileValidation($this->file);

        // Reset Form on Successful Submit
        if (Validation::$nameError == "" && Validation::$emailError == "" && Validation::$mobileNumError == "" && Validation::$genderError == "" && Validation::$passwordError == "" && Validation::$confirmPassError == "" && Validation::$fileError == "") {
            $_POST = [];
        }
    }

    public function onSubmit() {
        if (Validation::$nameError == "" && Validation::$emailError == "" && Validation::$mobileNumError == "" && Validation::$genderError == "" && Validation::$passwordError == "" && Validation::$confirmPassError == "" && Validation::$fileError == "") {
            $this->password = hash('sha512', $this->password);
            $filename = $this->file["name"];
            if(isset($_COOKIE["update"])) {
                $updateEmail = $_COOKIE["update"];
                $sql = "UPDATE users SET name='$this->name', email='$this->email', mobile='$this->mobileNum', gender='$this->gender', password='$this->password', file='$filename' where email = '$updateEmail'";
            } else {
                $sql = "INSERT INTO users VALUES ('$this->name', '$this->email', '$this->mobileNum', '$this->gender', '$this->password', '$filename')";
            }
    
            DatabaseConnection::startConnection();
            if (mysqli_query(DatabaseConnection::$conn, $sql)) {
                echo "<div class='submitted-data'>";
                echo "<h2>User Registered Successfully, Thanks!</h2>";
                echo "<h3>Submitted Data:</h3>";
                echo "<p><small>Name: </small>$this->name</p>";
                echo "<p><small>Email Address: </small>$this->email</p>";
                echo "<p><small>Mobile Number: </small>$this->mobileNum</p>";
                echo "<p><small>Gender: </small>$this->gender</p>";
                echo "<p><small>Uploaded Image:</small></p>";
                echo "<figure><img src='image-upload/".$filename."' alt='Your Profile Picture'></figure>";
                echo "</div>";
            } else {
                echo "An Error Occurred " . mysqli_error(DatabaseConnection::$conn);
            }
            DatabaseConnection::closeDBConnection();
            // Delete 'Update' Cookie after successfull Update of DB
            if(isset($_COOKIE["update"])) {
                setcookie("update", "", time() - 300, "/", "", 0);
            }
        }
    }
}