<?php

class RegisterUser {
    public $name;
    public $email;
    public $mobileNum;
    public $gender;
    public $password;
    public $confirmPass;
    public $file;

    public function validateFields() 
    {
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
        if (Validation::checkIfAllFieldsAreValid()) {
            $_POST = [];
        }
    }

    public function onSubmit() 
    {
        if (Validation::checkIfAllFieldsAreValid()) {
            $this->password = hash('sha512', $this->password);
            $filename = $this->file["name"];
            if(isset($_COOKIE["update"])) {
                $updateEmail = $_COOKIE["update"];
                $sql = "UPDATE users SET name='$this->name', email='$this->email', mobile='$this->mobileNum', gender='$this->gender', password='$this->password', file='$filename' where email = '$updateEmail'";
            } else {
                $sql = "INSERT INTO users VALUES ('$this->name', '$this->email', '$this->mobileNum', '$this->gender', '$this->password', '$filename')";

                // $stmt = $conn->prepare("INSERT INTO users (name, email, mobile, gender, password, file) VALUES (?, ?, ?, ?, ?, ?)");
                // $stmt->bind_param("ssssss", $this->name, $this->email, $this->mobileNum, $this->gender, $this->password, $filename);

                // // set parameters and execute
                // $stmt->execute();
                // $stmt->close();
            }

    
            DatabaseConnection::startConnection();
            if (mysqli_query(DatabaseConnection::$conn, $sql)) {
                echo "<div class='submitted-data'>";
                if(isset($_COOKIE["update"])) {
                    echo "<h2>User Updated Successfully, Thanks!</h2>";
                } else {
                    echo "<h2>User Registered Successfully, Thanks!</h2>";
                }
                echo "<h3>Submitted Data:</h3>";
                echo "<p><small>Name: </small>$this->name</p>";
                echo "<p><small>Email Address: </small>$this->email</p>";
                echo "<p><small>Mobile Number: </small>$this->mobileNum</p>";
                echo "<p><small>Gender: </small>$this->gender</p>";
                echo "<p><small>Uploaded Image:</small></p>";
                echo "<figure><img src='image-upload/" . $filename . "' alt='Your Profile Picture'></figure>";
                echo "</div>";
            } else {
                echo "An Error Occurred " . mysqli_error(DatabaseConnection::$conn);
            }
            DatabaseConnection::closeDBConnection();
            if(isset($_COOKIE["update"])) {
                // Update Email in Cookie
                setcookie("email", $this->email, time() + 365 * 24 * 60 * 60, "/", "", 0);
                // Delete 'Update' Cookie after successfull Update of DB
                setcookie("update", "", time() - 300, "/", "", 0);
            }
        }
    }
}