<?php

if (isset($_POST['submit'])) {
    $uuid = $_POST['uuid'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteUser($conn, $uuid);
} else {
    header("Location: ../index.php");
    exit;
}
