<?php

class DatabaseConnection {
    private static $servername = "localhost";
    private static $databaseUsername = "root";
    private static $databasePassword = "";
    private static $databaseName = "form";
    public static $conn;

    // Creating connection
    static function startConnection() {
        self::$conn = mysqli_connect(self::$servername, self::$databaseUsername, self::$databasePassword, self::$databaseName);

        if (self::$conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    static function closeDBConnection() {
        // Close connection
        mysqli_close(self::$conn);
    }
}