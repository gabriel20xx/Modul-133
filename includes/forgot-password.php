<?php

if (isset($_POST["submit"])) {
    $email = $_POST["email"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (emailExists($conn, $email) !== false) {
        header("location: ../forgot_password.php?error=emailnotindatabase");
        exit();
    };

    sendEmailPasswordReset($email);

    header("Location: ../login.php?error=passwordresetemailsent");
    exit;
} else {
    header("location: ../index.php");
    exit();
}