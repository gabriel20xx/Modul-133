<?php

if (isset($_POST["submit"])) {
    $blog_uuid = $_POST["blog_uuid"];
    $comment_uuid = $_POST["comment_uuid"];
    $description = $_POST["description"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    editComment($conn, $blog_uuid, $comment_uuid, $description);

    exit();
} 
else {
    header("location: ../index.php");
    exit();
}
