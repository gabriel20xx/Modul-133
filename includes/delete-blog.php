<?php

if (isset($_POST["submit"])) {

    $id = $_POST["id"];

    require_once 'connect-db.php';
    require_once 'functions.php';

    deleteBlog($conn, $id);
} 
else {
    exit();
}

