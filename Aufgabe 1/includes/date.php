<!-- Uhrzeit und Datum-->
<?php
function Datum()
{
    $datum = date("d.m.Y");
    $uhrzeit = date("H:i");
    $datetime = $datum . " - " . $uhrzeit . " Uhr";
    return $datetime;
}
