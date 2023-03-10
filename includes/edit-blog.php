<?php
    // Redirect the user to the login page or any other page

if (isset($_POST["submit"])) {

    $id = $_POST["id"];

    require_once 'connect-db.php';
    require_once 'functions.php';


    editBlog($conn, $id);


    header("Location: ../forum.php");
    exit;
}
?>
