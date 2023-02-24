<?php

function ausgabe(){
    $name = $_GET['name'];
    $personalnummer = $_GET['personalnummer'];
    $mailadresse = $_GET['mailadresse'];
    $passwort = $_GET['passwort'];
    $AI = $_GET['AI'];
    $ST = $_GET['ST'];
    $IP = $_GET['IP'];
    $BI20c = $_GET['BI20c'];
    $BI20d = $_GET['BI20d'];
    $other = $_GET['other'];
    $output = $name . ' ' . $personalnummer . ' ' . $passwort . ' ' . $AI . ' ' . $ST . ' ' . $IP . ' ' . $BI20c . ' ' . $BI20d . ' ' . $other;
    return $output;
}

if (isset($_GET['submit']) ) {
    ausgabe();
}

