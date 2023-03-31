<?php

if (isset($_POST['submit'])) {

    $uuid = $_SESSION['uuid'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteUser($conn, $uuid);

} else {
    header("location: ../profile/$uuid.php");
    exit();
}