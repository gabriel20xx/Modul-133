<?php 

if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $category = $_POST["category"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (emptyInputCreateBlog($title, $description) !== false) {
        header("location: ../new_blog.php?error=emptyinput");
        exit();
    };

    if (checkUserLogin() !== false) {
        exit();
    };

    createBlog($conn, $title, $description, $category);

} else {
    header("location: ../new_blog.php");
    exit();
}