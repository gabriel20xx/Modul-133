<?php
$uuid = $_POST['uuid'];
echo "<p>$uuid dies ist die uuid</p>";
if (isset($_POST['submit'])) {
    $uuid = $_POST['uuid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'connect-db.php';
    require_once 'functions.php';

    updateUser($conn, $uuid, $username, $email, $password);

} else {
    echo "<p>$uuid dies ist die uuid2</p>";
    //header("location: ../profile/$uuid.php");
    exit();
}