<?php

if (isset($_POST['submit'])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_rep = $_POST["password_rep"];

    require_once 'connect-db.php';
    require_once 'functions.php';


    if (emptyInputSignup($username, $email, $password, $password_rep) !== false){
        header("location: ../register.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($username) !== false){
        header("location: ../register.php?error=invalidusername");
        exit();
    }
    if (invalidEmail($email) !== false){
        header("location: ../register.php?error=invalidemail");
        exit();
    }
    if (passwordMatch($password, $password_rep) !== false){
        header("location: ../register.php?error=passwordsdontmatch");
        exit();
    }
    if (usernameExists($conn, $username, $email) !== false){
        header("location: ../register.php?error=usernametaken");
        exit();
    }

    $uuid = uuid_create(UUID_TYPE_RANDOM);

    createUser($conn, $uuid, $username, $email, $password);
}
else {
    header("location: ../register.php");
}
