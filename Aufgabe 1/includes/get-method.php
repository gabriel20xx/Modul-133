<?php

if (isset($_POST['submit']) ) {
    $name = $_POST['name'];
    $personalnummer = $_POST['personalnummer'];
    $mailadresse = $_POST['mailadresse'];
    
    require_once 'connect-db.php';
    require_once 'functions.php';


    insertValues($conn, $name, $personalnummer, $mailadresse);
}
else {
    header("location: ../index.php");
}