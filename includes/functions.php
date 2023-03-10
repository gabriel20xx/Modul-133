<?php

# Create User
function createUser($conn, $uuid, $username, $email, $password) {
    $sql = "INSERT INTO users (uuid, username, email, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $uuid, $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $sql = "SELECT * FROM users WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uuid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $uuid = $row['uuid'];
            copy('../profiletemplate.php', '../profiles/'.$uuid.'.php');
            mysqli_stmt_close($stmt);
            header("location: ../register.php?error=none");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    exit();
}

# Login User
function loginUser($conn, $username, $password) {
    $usernameExists = usernameExists($conn, $username, $username);

    if ($usernameExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $usernameExists["password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPassword === true) {
        session_start();
        $_SESSION["uuid"] = $usernameExists["uuid"];
        $_SESSION["username"] = $usernameExists["username"];
        header("location: ../index.php?error=loggedin");
        exit();
    }
}

# Registration Functions
function emptyInputSignup($username, $email, $password, $password_rep) {
    if (empty($username) || empty($email) || empty($password) || empty($password_rep)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $password_rep) {
    if ($password !== $password_rep) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function usernameExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

# Login functions
function emptyInputLogin($username, $password) {
    if (empty($username) || empty($password)) {
        $result = true;
    }
    else { 
        $result = false;
    }
    return $result;
}


# Hier kommen alle Funktionen (??berpr??fung der Daten und Daten(-bank)verarbeitung)
function createBlog($conn, $uuid, $title, $description) {
    $createdAt = date('Y-m-d H:i:s');
    $createdBy = $_SESSION["uuid"];

    $sql = "INSERT INTO blogs (uuid, title, description, createdAt, user_uuid) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../new_blog.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $uuid, $title, $description, $createdAt, $createdBy);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    # Create Blog page

    $sql = "SELECT * FROM blogs WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../forum.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uuid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $uuid = $row['uuid'];
        copy('../blogtemplate.php', '../blogs/'.$uuid.'.php');
        mysqli_stmt_close($stmt);
        header("location: ../forum.php?error=postcreated");
        exit();
    }

    mysqli_stmt_close($stmt);
    exit();
}

function deleteBlog($conn, $uuid) {
    $sql = "SELECT * FROM blogs WHERE uuid = '$uuid'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $createdBy = $row['createdBy'];

            if (!isset($_SESSION["uuid"]) == $createdBy) {
                header("location: ../blogs/$uuid.php?error=notauthorized");
                exit();
            }

            $sql = "DELETE FROM blogs WHERE uuid = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../blogs/$uuid.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $uuid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        
        
            // Delete the blog
            unlink("../blogs/$uuid.php");
            header("Location: ../forum.php?error=postdeleted");
            exit;

        }
    }
}

function emptyInputCreateBlog($title, $description) {
    if (empty($title) || empty($description)) {
        $result = true;
    }
    else { 
        $result = false;
    }
    return $result;
}

function checkUserLogin() {
    if (!isset($_SESSION["uuid"])) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

