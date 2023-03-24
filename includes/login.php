<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rememberMe == 0;
    if (isset($_POST['remember_me']) && $_POST['remember_me'] == 1){
        $rememberMe = 1;
    } else {
        $rememberMe = 0;
    }

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (emptyInputLogin($username, $password) !== false){
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $password, $rememberMe);
}
else {
    header("location: ../login.php");
    exit();
}
