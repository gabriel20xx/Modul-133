<?php

if (isset($_POST["submit"])) {
    $blog_uuid = $_POST["blog_uuid"];
    $uuid = $_POST["comment_uuid"];
    $description = $_POST["description"];
    $type = 'comments';

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

    editComment($conn, $uuid, $blog_uuid, $description);

    header("Location: ../blogs/$blog_uuid.php?error=commentupdated");
    exit();
} 
else {
    header("location: ../index.php");
    exit();
}
