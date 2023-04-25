<?php

if (isset($_POST['submit'])) {
    $uuid = $_POST['uuid'];
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

    deleteUser($conn, $uuid);

    header("Location: ../index.php?error=userdeleted");
    exit();

} else {
    header("Location: ../index.php");
    exit;
}