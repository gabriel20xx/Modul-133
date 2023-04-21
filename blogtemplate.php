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
    <div class='container'>
        <div class='errors'>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "stmtfailed") {
                    echo
                    '<div class="alert alert-danger" role="alert">
                    Something went wrong!
                    </div>';
                } else if ($_GET["error"] == "emptyinput") {
                    echo
                    '<div class="alert alert-danger" role="alert">
                    Please fill in the field!
                    </div>';
                } else if ($_GET["error"] == "commentcreated") {
                    echo
                    '<div class="alert alert-success" role="alert">
                    Comment created!
                    </div>';
                }
            }
            ?>
        </div>

        <!-- Insert Blog Code here-->
        <div class="text-center">
            <?php
            $sql = "SELECT * FROM blogs WHERE uuid = '$filename'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $uuid = $row['uuid'];
                    $title = $row['title'];
                    $description = $row['description'];
                    echo "<h1 class='border'>$title</h1>";
                    echo "<p class='border'>$description</p>";
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
                        " 
                            <a class='mt-2 btn btn-secondary' href='../edit_blog.php?edit=$uuid' role='button'>Edit</a>
                            <form action='../includes/delete-blog.php' method='post'>
                            <input type='hidden' name='uuid' value='$uuid'>
                            <button type='submit' class='mt-2 btn btn-danger' name='submit'>Delete</button>
                            </form>";
                    }
                }
            }
            ?>
        </div>
        <!-- Comment section-->
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
                    }
        ?>
                    <form action='../includes/edit-comment.php' method='post'>
                        <textarea class="form-control" name="description" id="description" rows="5"><?php echo $description ?></textarea>
                        <p><?php echo $createdAt ?></p>
                        <p><?php echo $username ?></p>

                        <?php if (isset($_SESSION['uuid']) && $_SESSION['uuid'] == $user_uuid) : ?>
                            <input type='hidden' name='blog_uuid' value='<?php echo $uuid ?>'>
                            <input type='hidden' name='comment_uuid' value='<?php echo $comment_uuid ?>'>
                            <button type='button' class='btn btn-secondary' name='submit' id='edit-btn'>Edit</button>
                            <button type='submit' class='btn btn-primary' name='submit' id='save-btn'>Save</button>
                    </form>

                    <form action='../includes/delete-comment.php' method='post'>
                        <input type='hidden' name='blog_uuid' value='<?php echo $uuid ?>'>
                        <input type='hidden' name='comment_uuid' value='<?php echo $comment_uuid ?>'>
                        <button type='submit' class='mt-2 btn btn-danger' name='submit' id='delete-btn'>Delete</button>
                    </form>
                <?php endif; ?>
    <?php
                }
            }
        }
    ?>

    <?php
    if (isset($_SESSION["uuid"])) {

        echo "
        <form action='../includes/create-comment.php' method='post'>
            <div class='form-floating'>
                <textarea class='form-control' placeholder='Leave a comment here' name='description' id='description' style='height: 100px'></textarea>
                <label for='description'>Comments</label>
            </div>
            <input type='hidden' name='blog_uuid' value='$filename'>
            <button class='btn btn-lg mb-3 btn-success' name='submit' type='submit'>Add Comment</button>
        </form>
        ";
    }

    ?>
    </div>
    <?php
    include_once '../everywhere/footer.php'
    ?>

<script>
    var editBtn = document.getElementById("edit-btn");
    var saveBtn = document.getElementById("save-btn");
    var deleteBtn = document.getElementById("delete-btn");
    var descriptionInput = document.getElementById("description");

    // Enable form inputs and show/hide buttons on edit click
    editBtn.addEventListener("click", function() {
      editBtn.classList.add("d-none");
      saveBtn.classList.remove("d-none");
      deleteBtn.classList.add("d-none");
      descriptionInput.disabled = false;
    });

    // Disable form inputs and show/hide buttons on save click
    saveBtn.addEventListener("click", function() {
      editBtn.classList.remove("d-none");
      saveBtn.classList.add("d-none");
      deleteBtn.classList.remove("d-none");
    });

    // Show confirmation dialog on delete click
    /*     function confirmDelete() {
          if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                    document.forms[0].action='../includes/delete-user.php';
            alert("Account deleted successfully.");
          }
        } */
  </script>
</body>