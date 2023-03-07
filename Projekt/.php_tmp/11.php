<?php 
include_once '../includes/connect-db.php';
include_once '../everywhere/header.php';
?>

<?php
$filename = basename(__FILE__, '.php');
$newTitle = str_replace('_', ' ', $filename);
?>

<body>
    <?php
    include_once '../everywhere/navbar.php';
    ?>

    <!-- Insert Homepage Code here-->
    <div class="mb-3 p-5 text-center">
        <?php
            $sql = "SELECT * FROM blogs WHERE id = '$newTitle'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['title'];
                    $description = $row['description'];
                    echo "<h1>$title</h1>";
                    echo "<p>$description</p>";
                }
            }
        ?>
    </div>
    <a class="bi bi-trash btn btn-secondary" href="#" role="button"><i class="bi bi-trash"></i></a>
    <a class="bi bi-trash btn btn-danger" href="#" role="button"></a>


    <?php
    include_once '../everywhere/footer.php'
    ?>
</body>