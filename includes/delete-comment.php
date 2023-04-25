<?php

if (isset($_POST["submit"])) {
    $blog_uuid = $_POST["blog_uuid"];
    $uuid = $_POST["comment_uuid"];
    $type = 'comments';

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (checkUserLogin() !== false) {
        header("location: ../login.php?error=notloggedin");
        exit();
    };

    if (checkCorrectUser($conn, $uuid, $type) !== false) {
        header("location: ../blogs/$blog_uuid.php?error=notauthorized");
        exit();
    };

    deleteComment($conn, $uuid, $blog_uuid);

    header("Location: ../blogs/$blog_uuid.php?error=commentdeleted");
    exit;
} 
else {
    exit();
}

