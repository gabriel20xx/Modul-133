<?php

if (isset($_GET['email']) && isset($_GET['code'])) {
    $email = $_GET['email'];
    $verification_code = $_GET['code'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    if (verifyEmail($conn, $email, $verification_code) !== false) {
        header("location: ../register.php?error=verificationfailed");
        exit();
    };

    header("Location: ../login.php?error=verificationsuccessfull");
    exit;
} else {
    header("location: ../index.php");
    exit();
}