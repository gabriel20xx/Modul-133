<?php
    // Redirect the user to the login page or any other page

if (isset($_POST["submit"])) {
    $uuid = $_POST["uuid"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    editBlog($conn, $uuid);

    header("Location: ../forum.php");
    exit;
}
?>
