<?php

use PHP\BitTorrent\Torrent;

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

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userid = $row['id'];
            $sql = "INSERT INTO profileimage (userid, status) VALUES ('$userid', 1)";
            mysqli_query($conn, $sql);
        }
    }
    exit();
}

function emptyInputLogin($username, $password) {
    if (empty($username) || empty($password)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

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
        header("location: ../index.php");
        exit();
    }
}

function checkVideoType($videoName) {
    $videoExt = explode('.', $videoName);
    $videoActualExt = strtolower(end($videoExt));

    $allowed = array('mov', 'mp4', 'webm');

    if (!in_array($videoActualExt, $allowed)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkThumbnailType($thumbnailName) {
    $thumbnailExt = explode('.', $thumbnailName);
    $thumbnailActualExt = strtolower(end($thumbnailExt));

    $allowed = array('jpg', 'jpeg', 'png', 'bmp');

    if (!in_array($thumbnailActualExt, $allowed)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
};

function checkThumbnailSize($thumbnailSize) {
    if ($thumbnailSize < 10000000) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;

}

function checkVideoSize($videoSize) {
    if ($videoSize > 100000) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function getVideoLength($videoTmpName) {
    include_once('../external/getid3/getid3.php');
    $getID3 = new getID3;
    $file = $getID3->analyze($videoTmpName);
    $videoLength = $file['playtime_string'];
    return $videoLength;
}

function combineTags(...$tag) {

}

function titleExists($conn, $title) {
    $sql = "SELECT * FROM media WHERE title = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../upload.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $title);
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

function moveVideo($videoName, $videoTmpName, $title) {
    $videoExt = explode('.', $videoName);
    $videoActualExt = strtolower(end($videoExt));
    $videoNameNew = $title.".mp4";
    $videoDestination = '../videos/'.$videoNameNew;
    move_uploaded_file($videoTmpName, $videoDestination);
    return $videoDestination;
}

function moveThumbnail($thumbnailName, $thumbnailTmpName, $title) {
    $thumbnailExt = explode('.', $thumbnailName);
    $thumbnailActualExt = strtolower(end($thumbnailExt));
    $thumbnailNameNew = $title.".png";
    $thumbnailDestination = '../thumbnails/'.$thumbnailNameNew;
    move_uploaded_file($thumbnailTmpName, $thumbnailDestination);
    return $thumbnailDestination;
}

function uploadVideo($conn, $title, $author, $description, $thumbnailDestination, $videoDestination, $tags, $uploadTime, $videoLength) {
    $sql = "INSERT INTO media (title, author, description, thumbnail_url, video_link, tags, uploadtime, length)
    VALUES ('$title', '$author', '$description', '$thumbnailDestination', '$videoDestination', '$tags', '$uploadTime', '$videoLength');";
    mysqli_query($conn, $sql);

    header("location: ../upload.php?error=none");
}

function generateThumbnail($videoName, $title) {
    require '../vendor/autoload.php';

    $sec = 5;
    $thumbnail = $title.'.png';

    $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($videoName);
    $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
    $frame->save($thumbnail);
    echo $thumbnail;

    $thumbnailDestination = '../thumbnails/'.$thumbnail;
    move_uploaded_file($thumbnail, $thumbnailDestination);
    return $thumbnailDestination;
}

function getVideoTitle($conn, $title) {
    $sql = "SELECT * FROM media WHERE title = '$title';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            return $title;
        }
    }
}

function getVideoDescription($conn, $title) {
    $sql = "SELECT * FROM media WHERE title = '$title';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $description = $row['description'];
            return $description;
        }
    }
}

function createTorrentFile($videoDestination, $title) {
    $torrent = new Torrent( array( 'test.mp3', 'test.jpg' ), 'http://torrent.tracker/announce' );
    file_put_contents('new.torrent', $torrent);
}

function createVideoPage($title) {
    $newTitle = str_replace(" " AND "." AND "/", "_", $title);
    copy('../videopagetemplate.php', '../pages/'.$newTitle.'.php');
}