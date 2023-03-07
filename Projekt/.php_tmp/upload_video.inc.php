<?php
include 'connect.inc.php';
include 'functions.inc.php';

if (isset($_POST['submit'])) {
    $video = $_FILES['video'];
    $thumbnail = $_FILES['thumbnail'];


    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $tags = "";

    $videoName = $_FILES['video']['name'];
    $videoTmpName = $_FILES['video']['tmp_name'];
    $videoSize = $_FILES['video']['size'];
    $videoError = $_FILES['video']['error'];

    $thumbnailName = $_FILES['thumbnail']['name'];
    $thumbnailTmpName = $_FILES['thumbnail']['tmp_name'];
    $thumbnailSize = $_FILES['thumbnail']['size'];
    $thumbnailError = $_FILES['thumbnail']['error'];

    $videoLength = getVideoLength($videoTmpName);

    $uploadTime = date_timestamp_get(new DateTime());
    if ($thumbnailError === 0) {
        if (checkThumbnailType($thumbnailName) !== false) {
            header("location: ../upload.php?error=wrongthumbnailextension");
            exit();
        }
        if (checkThumbnailSize($thumbnailSize) !== false) {
            header("location: ../upload.php?error=wrongthumbnailsize");
            exit();
        }
        $thumbnailDestination = moveThumbnail($thumbnailName, $thumbnailTmpName, $title);
    } else {
        $thumbnailDestination = generateThumbnail($videoName, $title);
    }

    if ($videoError !== 0) {
        header("location: ../upload.php?error=videoerror");
        exit();
    }

    if (checkVideoType($videoName) !== false) {
        header("location: ../upload.php?error=wrongvideoextension");
        exit();
    }

    if (checkVideoSize($videoSize) !== false) {
        header("location: ../upload.php?error=wrongvideosize");
        exit();
    }

    if (titleExists($conn, $title) !== false) {
        header("location: ../upload.php?error=titleexists");
        exit();
    }

    $videoDestination = moveVideo($videoName, $videoTmpName, $title);

    uploadVideo($conn, $title, $author, $description, $thumbnailDestination, $videoDestination, $tags, $uploadTime, $videoLength);
    createVideoPage($title);
    createTorrentFile($videoDestination, $title);
} else {
    header("location: ../upload.php");
}
