<?php
$dbServer = "8.34.222.223";
$dbUsername = "phpuser";
$dbPassword = "phppassword";
$dbName = "m133"; #projektm133

// Create connection
$conn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);

session_start();
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo ("Database connected successfully");