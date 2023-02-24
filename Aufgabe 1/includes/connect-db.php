<?php
$dbServer = "localhost";
$dbUsername = "phpuser";
$dbPassword = "phppassword";
$dbName = "aufgabe1";

// Create connection
$conn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);
session_start();
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

print("Database connected successfully");