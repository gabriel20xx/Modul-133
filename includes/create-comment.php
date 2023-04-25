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
        header("location: ../login.php?error=notloggedin");
        exit();
    };
    
    createComment($conn, $description, $blog_uuid);

    header("location: ../blogs/$blog_uuid.php?error=commentcreated");
    exit();

} else {
    header("location: ../forum.php");
    exit();
}