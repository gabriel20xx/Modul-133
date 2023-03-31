<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<!-- Redirect User to Login page if there is no valid session -->
<?php
if (!isset($_SESSION["uuid"])) {
    header("location: ../login.php?error=notloggedin");
    exit();
}
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
    ?>

    <!-- Insert Blogpage Code here -->
    <div class='container'>
        <div class="errors">
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo
                    '<div class="alert alert-danger" role="alert">
                Fill in all fields!
                </div>';
                }
            }
            ?>
        </div>



        <!-- Change this to a dropdown choose button -->


        <form action="includes/create-blog.php" method="post">
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" aria-label="Default select example">
                    <option selected>Category</option>
                    <option value="1">Politics</option>
                    <option value="2">Sports</option>
                    <option value="3">Music</option>
                    <option value="4">Art</option>
                    <option value="5">TBZ</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Insert good title here">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="10" placeholder="Insert good description here"></textarea>
            </div>
            <button class="w-100 btn btn-lg mb-3 btn-success" name="submit" type="submit">Create Post</button>
        </form>
    </div>

    <?php
    include_once 'everywhere/footer.php'
    ?>
</body>