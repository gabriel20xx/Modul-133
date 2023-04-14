<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // TODO: validate and sanitize the data
    require_once 'connect-db.php';
    require_once 'functions.php';

    updateUser($conn, $uuid, $username, $email, $password);
    // TODO: update user data in database using the retrieved form data
    echo "<p>$uuid dies ist die uuid2</p>";
    // Redirect user to profile page
    header('Location: ../profile.php');
    exit;
}