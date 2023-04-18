<?php

if (isset($_POST['submit'])) {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    header("Location: ../index.php?uuid=$uuid-username=$username-email=$email-password=$password");

} else {
    header("Location: ../index.php");
    exit;
}