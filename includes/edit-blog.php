<?php

if (isset($_POST["submit"])) {
    $uuid = $_POST["uuid"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $type = 'blogs';

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

    editBlog($conn, $uuid, $title, $description, $category);

    header("Location: ../blogs/$uuid.php?error=postupdated");
    exit();
} 
else {
    header("location: ../index.php");
    exit();
}
