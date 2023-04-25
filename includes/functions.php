<?php

function loginUser($conn, $username, $password, $rememberMe)
{
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
    } else if ($checkPassword === true) {
        if ($rememberMe === true) {
            $expiration = time() + (86400 * 30); // Set the expiration time for the cookie (in seconds), 30 days from now
            $token = bin2hex(random_bytes(32)); // Generate a random token to use as the cookie value
            setcookie('login_token', $token, $expiration, '/'); // Set the cookie

            $sql = "UPDATE users SET cookie=? WHERE uuid=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../register.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ss", $cookie, $uuid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        session_start();
        $_SESSION["uuid"] = $user["uuid"];
        $_SESSION["username"] = $user["username"];
    }
}

function logoutUser()
{
    session_start();
    session_unset();
    session_destroy();
}

function createUser($conn, $username, $email, $password)
{
    $uuid = generateUUID();
    $verification_code = md5(uniqid(rand(), true));
    $verified = false;
    $role = 'user';
    $salt = bin2hex(random_bytes(8));
    $pepper = 'thegctboys';
    $hashedPassword = password_hash($salt . $password . $pepper, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (uuid, username, email, password, salt, role, verified, verification_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $uuid, $username, $email, $hashedPassword, $salt, $role, $verified, $verification_code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    sendEmailVerification($email, $verification_code);

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
            copy('../profiletemplate.php', '../profiles/' . $uuid . '.php');
            mysqli_stmt_close($stmt);
            $rememberMe = false;
            loginUser($conn, $username, $password, $rememberMe);
        }
    }
}

function createBlog($conn, $title, $description, $category_id)
{
    $uuid = generateUUID();
    $createdAt = date('Y-m-d H:i:s');
    $createdBy = $_SESSION["uuid"];

    $sql = "INSERT INTO blogs (uuid, title, description, category_id, createdAt, user_uuid) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../new_blog.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $uuid, $title, $description, $category_id, $createdAt, $createdBy);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    copy('../blogtemplate.php', '../blogs/' . $uuid . '.php');
}

function createComment($conn, $description, $blog_uuid)
{
    $uuid = generateUUID();
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
}

function editUser($conn, $uuid, $username, $email, $password)
{
    $sql = "SELECT * FROM users WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uuid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        $salt = $row['salt'];

        if (!password_verify($password, $hashedPassword)) {
            $salt = bin2hex(random_bytes(8)); // generate a unique salt value for each user
            $pepper = 'thegctboys'; // define a unique pepper value for our application
            $hashedPassword = password_hash($salt . $password . $pepper, PASSWORD_DEFAULT);
        }

        $sql = "UPDATE users SET username=?, email=?, password=?, salt=? WHERE uuid=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPassword, $salt, $uuid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../profiles/$uuid.php?error=noresult");
        exit();
    }
}

function editBlog($conn, $uuid, $title, $description, $category)
{
    $sql = "SELECT * FROM categories WHERE name = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../blogs/$uuid.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_id = $row['id'];
    }

    $sql = "UPDATE blogs SET title = ?, description = ?, category_id = ? WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../blogs/$uuid.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssis", $title, $description, $category_id, $uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function editComment($conn, $uuid, $blog_uuid, $description)
{
    $sql = "UPDATE comments SET description = ? WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../blogs/$blog_uuid.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $description, $uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteUser($conn, $uuid)
{
    $sql = "DELETE FROM users WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profiles/$uuid.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    logoutUser();
    unlink("../profiles/$uuid.php");
}

function deleteBlog($conn, $uuid)
{
    $sql = "DELETE FROM blogs WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../blogs/$uuid.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    unlink("../blogs/$uuid.php");
}

function deleteComment($conn, $uuid, $blog_uuid)
{
    $sql = "DELETE FROM comments WHERE uuid = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../blogs/$blog_uuid.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $uuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

# General Functions
function emptyInputSignup($username, $email, $password, $password_rep)
{
    if (empty($username) || empty($email) || empty($password) || empty($password_rep)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordRequirements($password)
{
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

function passwordMatch($password, $password_rep)
{
    if ($password !== $password_rep) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function usernameExists($conn, $username, $email)
{
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
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData)) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;

    mysqli_stmt_close($stmt);
}

function emptyInputLogin($username, $password)
{
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function generateUUID()
{
    $result = uuid_create(UUID_TYPE_RANDOM);
    return $result;
}

function emptyInputCreateBlog($title, $description)
{
    if (empty($title) || empty($description)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkUserLogin()
{
    if (!isset($_SESSION["uuid"])) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkCorrectUser($conn, $uuid, $type)
{
    $sql = "SELECT * FROM $type WHERE uuid = '$uuid'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_uuid = $row['user_uuid'];

            if (!isset($_SESSION["uuid"]) == $user_uuid) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        }
    }
}

function emptyInputCreateComment($description)
{
    if (empty($description)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function sendEmailVerification($email, $verification_code)
{
    $subject = "Email Verification";
    $message = "Thank you for registering. Your verification code is $verification_code. Click the following link to verify your email: http://thegctcorner.com/verify.php?email=$email&code=$verification_code";
    $headers = "From: info@thegctcorner.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail($email, $subject, $message, $headers);
}

function verifyEmail($conn, $email, $verification_code) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $database_code = $row['verification_code'];

        if ($database_code != $verification_code) {
            $result = true;
        } else {
            $verified = true;
            $verification_code = null;

            $sql = "UPDATE users SET verified=?, verification_code=? WHERE email=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../register.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "bss", $verified, $verification_code, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $result = false;
        }
        return $result;
    } else {
        return true;
    }
}

function sendEmailPasswordReset($email)
{
    $subject = "Password Reset";
    $message = "Click the following link to reset your password: http://thegctcorner.com/reset-password.php?email=$email&code=$verification_code";
    $headers = "From: info@thegctcorner.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail($email, $subject, $message, $headers);
}