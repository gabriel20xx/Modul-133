<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    updateUser($conn, $uuid, $username, $email, $password);

} else {
    header("location: ../profile/$uuid.php");
    exit();
}