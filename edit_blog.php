<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<>
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
                $category_id = $row['category_id'];
            }
        }
    }
    ?>

    <div class="container">
        <form action="includes/edit-blog.php" method="post">
            <input type='hidden' name='uuid' value='$uuid'>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" aria-label="Default select example">
                    <?php
                    $sql = "SELECT * FROM categories WHERE id = '$category_id'";
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);

                    if ($resultCheck > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $category = $row['name'];
                    }

                    echo "<option selected>$category</option>";
                    $sql = "SELECT COUNT(*) as count FROM categories";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $count = $row["count"];

                        for ($i = 0; $i < $count; $i++) {
                            $sql = "SELECT * FROM categories LIMIT 1 OFFSET " . $i;
                            $result = mysqli_query($conn, $sql);
                            $resultCheck = mysqli_num_rows($result);

                            if ($resultCheck > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $id = $row['id'];
                                $name = $row['name'];

                                echo "<option value='$id'>$name</option>";
                            }
                        }
                    }
                    ?>

                </select>
            </div>
            <input type='hidden' name='uuid' value='<?php echo $uuid ?>'>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="<?php echo $title ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description"><?php echo $description ?></textarea>
            </div>
            <button class="btn mb-3 btn-primary" name="submit" type="submit">Update Blog</button>
            <a href="blogs/<?php echo $uuid ?>.php">
                <div class="btn mb-3 btn-secondary">Cancel</div>
            </a>
        </form>
    </div>

    <?php
    include_once 'everywhere/footer.php'
    ?>