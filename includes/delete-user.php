<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uuid = $_POST['uuid'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteUser($conn, $uuid);

} else {
    header("location: ../profile/$uuid.php");
    exit();
}