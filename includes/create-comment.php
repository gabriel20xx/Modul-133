<?php

if (isset($_POST["submit"])) {
    $description = $_POST["description"];
    $blog_uuid = $_POST["blog_uuid"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (emptyInputCreateComment($description) !== false) {
        header("location: ../blogs/$blog_uuid.php?error=emptyinput");
        exit();
    };

    if (checkUserLogin() !== false) {
        exit();
    };

    createComment($conn, $description, $blog_uuid);
} else {
    header("location: ../forum.php");
    exit();
}
