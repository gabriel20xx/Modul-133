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

    <div class='errors'>
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "stmtfailed") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Something went wrong!
                </div>';
            }
            else if ($_GET["error"] == "emptyinput") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Please fill in the field!
                </div>';
            }
            else if ($_GET["error"] == "commentcreated") {
                echo 
                '<div class="alert alert-success" role="alert">
                Comment created!
                </div>';
            }
        }
    ?>
    </div>

    <!-- Insert Blog Code here-->
    <div class="mb-3 p-5 text-center container">
        <?php
            $sql = "SELECT * FROM blogs WHERE uuid = '$filename'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $uuid = $row['uuid'];
                    $title = $row['title'];
                    $description = $row['description'];
                    echo "<h1>$title</h1>";
                    echo "<p>$description</p>";
                }
            }
        ?>
        <?php
            $sql = "SELECT * FROM blogs WHERE uuid = '$filename'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $uuid = $row['uuid'];
                    $user_uuid = $row['user_uuid'];
                    if (isset($_SESSION['uuid']) == $user_uuid) {
                    echo 
                        "<form action='../includes/edit-blog.php' method='post'>
                        <input type='hidden' name='uuid' value='$uuid'>
                        <button type='submit' class='w-100 btn btn-secondary' name='submit'>Edit</button>
                        </form>
                
                        <form action='../includes/delete-blog.php' method='post'>
                        <input type='hidden' name='uuid' value='$uuid'>
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
            $count = $row["count"];

            for ($i = 0; $i < $count; $i++) {
                $sql = "SELECT * FROM comments WHERE blog_uuid ='$filename' ORDER BY createdAt DESC LIMIT $i, 1";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $comment_uuid = $row['uuid'];
                    $description = $row['description'];
                    $createdAt = $row['createdAt'];
                    $user_uuid = $row['user_uuid'];
                    $createdByUser = "SELECT * FROM users WHERE uuid = '$user_uuid'";
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

                        if (isset($_SESSION['uuid']) == $user_uuid) {
                            echo 
                                "<form action='../includes/edit-comment.php' method='post'>
                                <input type='hidden' name='uuid' value='$comment_uuid'>
                                <button type='submit' class='w-100 btn btn-secondary' name='submit'>Edit</button>
                                </form>
                        
                                <form action='../includes/delete-comment.php' method='post'>
                                <input type='hidden' name='uuid' value='$comment_uuid'>
                                <button type='submit' class='mt-2 w-100 btn btn-danger' name='submit'>Delete</button>
                                </form>";
                            }

                    }
                }
            }
        }
    ?>

    <div class="container">
        <form action="../includes/create-comment.php" method="post">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description" style="height: 100px"></textarea>
                <label for="description">Comments</label>
            </div>
            <input type='hidden' name='blog_uuid' value='<?php echo $filename ?>'>
            <button class="w-100 btn btn-lg mb-3 btn-success" name="submit" type="submit">Add Comment</button>
        </form>
    </div>

    <?php
    include_once '../everywhere/footer.php'
    ?>
</body>