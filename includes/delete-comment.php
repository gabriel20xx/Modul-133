<?php

if (isset($_POST["submit"])) {
    $blog_uuid = $_POST["blog_uuid"];
    $comment_uuid = $_POST["comment_uuid"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteComment($conn, $blog_uuid, $comment_uuid);
} else {
    exit();
}
