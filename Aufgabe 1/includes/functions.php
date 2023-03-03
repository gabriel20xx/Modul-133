<?php

function insertValues($conn, $name, $personalnummer, $mailadresse) {
    $sql = "INSERT INTO users (names, personalnummer, mailadresse) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, $name, $personalnummer, $mailadresse);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();

}