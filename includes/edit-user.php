<?php

if (isset($_POST['submit'])) {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = 'users';

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (checkUserLogin() !== false) {
        header("location: ../login.php?error=notloggedin");
        exit();
    };

    if (checkCorrectUser($conn, $uuid, $type) !== false) {
        header("location: ../profiles/$uuid.php?error=notauthorized");
        exit();
    };

    editUser($conn, $uuid, $username, $email, $password);

    header("Location: ../profiles/$uuid.php?error=profileupdated");
    exit();

} else {
    header("Location: ../index.php");
    exit;
}