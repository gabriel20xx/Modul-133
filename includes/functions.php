<?php

# Create User
function createUser($conn, $username, $email, $password) {
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?error=none");

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            copy('../profiletemplate.php', '../profiles/'.$id.'.php');
        }
    }
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
        $_SESSION["id"] = $usernameExists["id"];
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


# Hier kommen alle Funktionen (Überprüfung der Daten und Daten(-bank)verarbeitung)
function createBlog($conn, $title, $description) {
    # Add Date and Time
    # Add User
    $createdAt = date('Y-m-d H:i:s');
    $createdBy = $_SESSION["id"];
    # $createdBy = 1;

    $sql = "INSERT INTO blogs (title, description, createdAt, user_id) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../new_blog.php?error=stmtfailed");
        exit();
    }

    
    mysqli_stmt_bind_param($stmt, "ssss", $title, $description, $createdAt, $createdBy);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    # Create Blog page

    $sql = "SELECT * FROM blogs WHERE title = '$title' AND createdAt = '$createdAt";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        copy('../blogtemplate.php', '../blogs/'.$id.'.php');
        header("location: ../forum.php?error=postcreated");
        exit();
    }
    
    exit();
}

function deleteBlog($conn, $id) {
    $sql = "SELECT * FROM blogs WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $createdBy = $row['createdBy'];

            if (!isset($_SESSION["id"]) == $createdBy) {
                header("location: ../blogs/$id.php?error=notauthorized");
                exit();
            }

            $sql = "DELETE FROM blogs WHERE id = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../blogs/$id.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        
        
            // Delete the blog
            unlink("../blogs/$id.php");
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
    if (!isset($_SESSION["username"])) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

