<?php

if (isset($_POST["submit"])) {
    $uuid = $_POST["uuid"];
    $type = "blogs";

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (checkUserLogin() !== false) {
        header("location: ../login.php?error=notloggedin");
        exit();
    };

    if (checkCorrectUser($conn, $uuid, $type) !== false) {
        header("location: ../blogs/$uuid.php?error=notauthorized");
        exit();
    };

    deleteBlog($conn, $uuid);

    header("Location: ../forum.php?error=postdeleted");
    exit;
} 
else {
    exit();
}
