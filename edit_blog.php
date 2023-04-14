<?php 
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
    ?>
    <?php
        if (isset($_GET["edit"])) {
            $uuid = $_GET["edit"];
            $sql = "SELECT * FROM blogs WHERE uuid = '$uuid'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $uuid = $row['uuid'];
                    $title = $row['title'];
                    $description = $row['description'];
    
                }
            }
        }
    ?>

    <!-- Insert Blogpage Code here-->
    <div class="container">
        <form action="includes/edit-blog.php" method="post">
            <div class="mb-3">
            <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Insert good title here" value="<?php echo $title ?>">
            </div>
            <div class="mb-3">
            <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="10" placeholder="Insert description here"><?php echo $description ?></textarea>
            </div>
            <button class="btn btn-lg mb-3 btn-primary" name="submit" type="submit">Update Blog</button>
        </form>
    </div>

    <?php
    include_once 'everywhere/footer.php'
    ?>
</body>