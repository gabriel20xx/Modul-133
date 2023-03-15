<?php

if (isset($_POST["submit"])) {
    $uuid = $_POST["uuid"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteComment($conn, $uuid);
} 
else {
    exit();
}

