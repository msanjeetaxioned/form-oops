<?php

if(isset($_COOKIE["update"])) {
    $email = $_COOKIE["update"];
    DatabaseConnection::startConnection();
    $select = mysqli_query(DatabaseConnection::$conn, "select * from users where email = '$email'");

    $row = mysqli_fetch_assoc($select);
    $_POST['name'] = $row['name'];
    $_POST['email'] = $row['email'];
    $_POST['phone-num'] = $row['mobile'];
    $_POST['gender'] = $row['gender'];
    DatabaseConnection::closeDBConnection();
}