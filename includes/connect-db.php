<?php

$dbServer = "8.34.222.223";
$dbUsername = "phpuser";
$dbPassword = "phppassword";
$dbName = "m133";

// Create connection
$conn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);

session_start();
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if UUID Extension is loaded
if (!extension_loaded('uuid')) {
    die('The uuid extension is not loaded.');
}
