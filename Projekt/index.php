<?php 
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
    ?>

    <?php
        if (isset($_SESSION["username"])) {
            echo '
            <div class="alert alert-success" role="alert">
                Welcome ' . $_SESSION["username"] . '. You succesfully logged in
            </div>';
        }
    ?>

    <!-- Insert Homepage Code here-->
    <h1>Dies ist die Homepage</h1>

    <?php
    include_once 'everywhere/footer.php'
    ?>
</body>
