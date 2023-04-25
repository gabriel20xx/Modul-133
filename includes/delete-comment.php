<?php

if (isset($_POST["submit"])) {
    $blog_uuid = $_POST["blog_uuid"];
    $uuid = $_POST["comment_uuid"];
    $type = 'comments';

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (checkUserLogin() !== false) {
        exit();
    };

    if (checkCorrectUser($conn, $uuid, $type) !== false) {
        header("location: ../blogs/$uuid.php?error=notauthorized");
        exit();
    };

    deleteComment($conn, $uuid, $blog_uuid);

    header("Location: ../blogs/$blog_uuid.php?error=commentdeleted");
    exit;
} 
else {
    exit();
}

