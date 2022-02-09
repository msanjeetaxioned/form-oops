<?php

$fields;
if(isset($_COOKIE["update"])) {
    $email = $_COOKIE["update"];
    DatabaseConnection::startConnection();
    $select = mysqli_query(DatabaseConnection::$conn, "select * from users where email = '$email'");

    $fields = mysqli_fetch_assoc($select);
    DatabaseConnection::closeDBConnection();
}