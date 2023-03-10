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
                    $uuid = $row['uuid'];
                    $user_uuid = $row['user_uuid'];
                    if (isset($_SESSION['uuid']) == $user_uuid) {
                    echo 
                        "<form action='../includes/edit-blog.php' method='post'>
                        <input type='hidden' name='id' value='$uuid'>
                        <button type='submit' class='w-100 btn btn-secondary' name='submit'>Edit</button>
                        </form>
                
                        <form action='../includes/delete-blog.php' method='post'>
                        <input type='hidden' name='id' value='$uuid'>
                        <button type='submit' class='mt-2 w-100 btn btn-danger' name='submit'>Delete</button>
                        </form>";
                    }
                }
            }
        ?>
    </div>

    <?php
        $sql = "SELECT COUNT(*) AS count FROM comments WHERE blog_uuid ='$filename'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $count = $row[""];

            for ($i = 0; $i < $count; $i++) {
                $sql = "SELECT * FROM comments WHERE blog_uuid ='$filename' ORDER BY createdAt DESC LIMIT $i, 1";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $description = $row['description'];
                    $createdAt = $row['createdAt'];

                    $createdBy = $row['user_uuid'];
                    $createdByUser = "SELECT * FROM users WHERE uuid = '$createdBy'";
                    $result2 = mysqli_query($conn, $createdByUser);
                    $resultCheck2 = mysqli_num_rows($result2);
    
                    if ($resultCheck2 > 0) {
                        $row2 = mysqli_fetch_assoc($result2);
                        $username = $row2['username'];

                        echo "
                            <div class='container'>
                                <p>$description</p>
                                <p>$createdAt</p>
                                <p>$username</p>
                            </div>
                        
                        ";
                    }
                }
            }
        }
    ?>


    <div class="container">
        <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
        <label for="floatingTextarea2">Comments</label>
        </div>
    </div>

    <?php
    include_once '../everywhere/footer.php'
    ?>
</body>