<?php

if (isset($_POST['submit'])) {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    editUser($conn, $uuid, $username, $email, $password);

} else {
    header("Location: ../index.php");
    exit;
}