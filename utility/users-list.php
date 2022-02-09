<?php

class UsersList {
    public static $numOfUsers;

    public static function createUserList() {
        DatabaseConnection::startConnection();
        $select = mysqli_query(DatabaseConnection::$conn, "SELECT name, email, mobile, gender FROM users;");

        self::$numOfUsers = mysqli_num_rows($select);

        echo "<li>";
        echo "<span class='name'>Name</span>";
        echo "<span class='email'>Email Id</span>";
        echo "<span class='mobile'>Mobile No.</span>";
        echo "<span class='gender'>Gender</span>";
        echo "<span class='update'>Update User</span>";
        echo "<span class='delete'>Delete User</span>";
        echo "</li>";

        while($row = mysqli_fetch_assoc($select)) {
            echo "<li>";
            echo "<span class='name'>" . $row["name"] . "</span>";
            echo "<span class='email'>" . $row["email"] . "</span>";
            echo "<span class='mobile'>" . $row["mobile"] . "</span>";
            echo "<span class='gender'>" . $row["gender"] . "</span>";
            echo "<span class='update'><a href='http://localhost/php/form-oops/users.php?update=" . $row['email'] . "' title='Update'>Update</a></span>";
            echo "<span class='delete'><a href='http://localhost/php/form-oops/users.php?email=" . $row['email'] . "' title='Delete'>Delete</a></span>";
            echo "</li>";
        }
        DatabaseConnection::closeDBConnection();
    }

    public static function deleteUserFromDB() {
        $email = $_GET["email"];
        DatabaseConnection::startConnection();
        $delete = mysqli_query(DatabaseConnection::$conn, "delete from users where email = '$email'");
        DatabaseConnection::closeDBConnection();
        if($email == $_COOKIE["email"]) {
            setcookie("email", "", time() - 300, "/", "", 0);
            header('Location: http://localhost/php/form-oops/login.php');
        }
    }

    public static function updateUserInDB() {
        $email = $_GET["update"];

        setcookie("update", $email, time() + 24 * 60 * 60, "/", "", 0);
        header('Location: http://localhost/php/form-oops/index.php');
    }
}