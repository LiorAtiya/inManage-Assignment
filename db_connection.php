<?php
    function databaseConnection() {

        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'in_manage';

        $conn = new mysqli($host, $user, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // echo "Connected to MySQL successfully! </br>";
        return $conn;
    }
?>
