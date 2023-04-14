<?php
    // Redirect the user to the login page or any other page

if (isset($_POST["submit"])) {
    $uuid = $_POST["uuid"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $category = $_POST["category"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    editBlog($conn, $uuid, $title, $description, $category);

    exit();
}
?>
