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
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    echo "<h1>$title</h1>";
                    echo "<p>$description</p>";
                }
            }
        ?>
    </div>

    <?php
    $sql = "SELECT * FROM blogs WHERE id = '$newTitle'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            echo 
            "<form action='../includes/edit-blog.php' method='post'>
            <input type='hidden' name='id' value='$id'>
            <button type='submit' class='btn btn-secondary' name='submit'>Edit</button>
            </form>
    
            <form action='../includes/delete-blog.php' method='post'>
            <input type='hidden' name='id' value='$id'>
            <button type='submit' class='btn btn-danger' name='submit'>Delete</button>
            </form>";
        }
    }
?>

    

    <?php
    include_once '../everywhere/footer.php'
    ?>
</body>