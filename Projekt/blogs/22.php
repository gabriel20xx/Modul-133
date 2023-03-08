<?php 
include_once '../includes/connect-db.php';
include_once '../everywhere/header.php';
?>

<?php
$filename = basename(__FILE__, '.php');
?>

<body>
    <?php
    include_once '../everywhere/navbar.php';
    ?>

    <!-- Insert Blog Code here-->
    <div class="mb-3 p-5 text-center container">
        <?php
            $sql = "SELECT * FROM blogs WHERE id = '$filename'";
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
        <?php
            $sql = "SELECT * FROM blogs WHERE id = '$filename'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $user_id = $row['createdBy'];
                    if (isset($_SESSION['id']) == $user_id) {
                    echo 
                        "<form action='../includes/edit-blog.php' method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' class='w-100 btn btn-secondary' name='submit'>Edit</button>
                        </form>
                
                        <form action='../includes/delete-blog.php' method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' class='mt-2 w-100 btn btn-danger' name='submit'>Delete</button>
                        </form>";
                    }
                }
            }
        ?>
    </div>

    <?php
    include_once '../everywhere/footer.php'
    ?>
</body>