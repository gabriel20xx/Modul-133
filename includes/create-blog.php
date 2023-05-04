<?php

if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $category_id = $_POST["category"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (emptyInputCreateBlog($title, $description) !== false) {
        header("location: ../new_blog.php?error=emptyinput");
        exit();
    };

    if (checkUserLogin() !== false) {
        header("location: ../login.php?error=notloggedin");
        exit();
    };

    createBlog($conn, $title, $description, $category_id);

    header("location: ../forum.php?page=1&error=postcreated");
    exit();

} else {
    header("location: ../new_blog.php");
    exit();
}
