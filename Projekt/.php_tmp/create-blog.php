<?php 
if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];

    require_once 'connect-db.php';
    require_once 'functions.php';



    createBlog($conn, $title, $description);

} else {
    header("location: ../new_blog.php");
    exit();
}