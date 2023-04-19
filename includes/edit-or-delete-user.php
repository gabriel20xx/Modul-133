<?php

if (isset($_POST['save'])) {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    editUser($conn, $uuid, $username, $email, $password);

} else if (isset($_POST['delete'])) {
    $uuid = $_POST['uuid'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteUser($conn, $uuid);

} else {
    header("Location: ../index.php");
    exit;
}