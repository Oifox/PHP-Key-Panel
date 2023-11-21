<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

function getDBConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error connecting to database: " . $conn->connect_error);
    }

    return $conn;
}
?>