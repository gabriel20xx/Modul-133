<?php
include_once '../includes/connect.inc.php';
include_once '../everywhere/header.php';
include_once '../includes/functions.inc.php';
?>
<?php
$title = basename(__FILE__, '.php');
$newTitle = str_replace('_', ' ', $title);
?>
<body>
<?php include_once '../everywhere/navbar.php' ?>
<script>
    var viewer = new Kaleidoscope.Video({source: '../videos/<?php echo $newTitle?>.mp4', containerId: '#player'});
    viewer.render();
</script>
<!-- Content -->
<div class='main'>
    <div class='pages__container'>
        <br>
        <div class='player__container'>
            <video id='player' width='100%' height='auto' playsinline controls data-poster='../thumbnails/<?php echo $newTitle?>.png'>
                <source src='../videos/<?php echo $newTitle?>.mp4' type='video/mp4' />
            </video>
        </div>
        <div>
            <h1><?php echo getVideoTitle($conn, $title)?></h1>
            <h2><?php echo getVideoDescription($conn, $title)?></h2>
        </div>
    </div>
</div>
<?php
include_once '../everywhere/footer.php'
?>
</body>
</html>