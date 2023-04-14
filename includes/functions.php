<?php

# Create User
function createUser($conn, $username, $email, $password) {
    $uuid = uuid_create(UUID_TYPE_RANDOM);
    $sql = "INSERT INTO users (uuid, username, email, password, salt) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    $salt = bin2hex(random_bytes(8)); // generate a unique salt value for each user
    $pepper = 'thegctboys'; // define a unique pepper value for our application
    
    $hashedPassword = password_hash($salt . $password . $pepper, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $uuid, $username, $email, $hashedPassword, $salt);
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
            $rememberMe = false;
            loginUser($conn, $username, $password, $rememberMe);


            header("location: ../register.php?error=none");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    exit();
}

# Login User
function loginUser($conn, $username, $password, $rememberMe) {
    $user = usernameExists($conn, $username, $username);

    if (!$user) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $salt = $user["salt"]; // get the salt value of the user
    $pepper = 'thegctboys'; // define the unique pepper value for our application

    $hashedPassword = $user["password"];
    $checkPassword = password_verify($salt . $password . $pepper, $hashedPassword); // verify the hashed password with the salt and pepper

    if ($checkPassword === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPassword === true) {
        if ($rememberMe === true) {
            // Set the expiration time for the cookie (in seconds)
            $expiration = time() + (86400 * 30); // 30 days from now

            // Generate a random token to use as the cookie value
            $token = bin2hex(random_bytes(32));

            // Set the cookie
            setcookie('login_token', $token, $expiration, '/');

            // Store the token in a database or other storage mechanism
            // so that it can be verified later
        }
        session_start();
        $_SESSION["uuid"] = $user["uuid"];
        $_SESSION["username"] = $user["username"];
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

function passwordRequirements($password) {
    $hasNumber = preg_match('/\d/', $password);
    $hasChar = preg_match('/[a-zA-Z]/', $password);
    $hasSymbol = preg_match('/[^a-zA-Z\d]/', $password);

    if (strlen($password) < 8 || !$hasNumber || !$hasChar || !$hasSymbol) {
        $result = true;
    } else {
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
    $uuid = uuid_create(UUID_TYPE_RANDOM);
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
        header("location: ../forum.php?page=1&error=postcreated");
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
            $user_uuid = $row['user_uuid'];

            if (!isset($_SESSION["uuid"]) == $user_uuid) {
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

function createComment($conn, $description, $blog_uuid) {
    $uuid = uuid_create(UUID_TYPE_RANDOM);
    $createdAt = date('Y-m-d H:i:s');
    $user_uuid = $_SESSION["uuid"];

    $sql = "INSERT INTO comments (uuid, description, createdAt, blog_uuid, user_uuid) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../blogs/$blog_uuid.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $uuid, $description, $createdAt, $blog_uuid, $user_uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../blogs/$blog_uuid.php?error=commentcreated");
    exit();
}

function emptyInputCreateComment($description) {
    if (empty($description)) {
        $result = true;
    }
    else { 
        $result = false;
    }
    return $result;
}

function deleteComment($conn, $blog_uuid, $comment_uuid) {
    $sql = "SELECT * FROM comments WHERE uuid = '$comment_uuid'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_uuid = $row['user_uuid'];

            if (!isset($_SESSION["uuid"]) == $user_uuid) {
                header("location: ../blogs/$blog_uuid.php?error=notauthorized");
                exit();
            }

            $sql = "DELETE FROM comments WHERE uuid = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../blogs/$blog_uuid.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $comment_uuid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        
        header("Location: ../blogs/$blog_uuid.php?error=commentdeleted");
            exit;    
        }
    }
}

function updateUser($conn, $uuid, $username, $email, $password) {
    $sql = "SELECT * FROM users WHERE uuid = '$uuid'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    echo "<p>Test</p>";


    $sql = "UPDATE users SET username=?, email=?, password=?, salt=? WHERE uuid=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../register.php?error=stmtfailed");
      exit();
    }

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["password"] == $password){
            $hashedPassword = $row["password"];
        } else {
            $salt = bin2hex(random_bytes(8)); // generate a unique salt value for each user
            $pepper = 'thegctboys'; // define a unique pepper value for our application
            
            $hashedPassword = password_hash($salt . $password . $pepper, PASSWORD_DEFAULT);        
        }
    }

  
    
    mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPassword, $salt, $uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  
    header("Location: ../profiles/$uuid.php?error=profileupdated");
    exit();
}

function deleteUser($conn, $uuid) {
    $sql = "SELECT * FROM users WHERE uuid = '$uuid'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sql = "DELETE FROM users WHERE uuid = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../profiles/$uuid.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $uuid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            session_start();

            // Unset all of the session variables
            $_SESSION = array();
        
            // Destroy the session
            session_destroy();
        
            header("Location: ../index.php?error=userdeleted");
            exit;    
        }
    }
}
