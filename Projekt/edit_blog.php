<?php 
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
    ?>

    <!-- Insert Blogpage Code here-->
    <div>
        <form action="includes/edit-blog.php" method="post">
            <div class="mb-3">
            <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Insert good title here">
            </div>
            <div class="mb-3">
            <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="10" placeholder="Insert description here"></textarea>
            </div>
            <button class="btn btn-lg mb-3 btn-primary" name="submit" type="submit">Create Blog</button>
        </form>
    </div>

    <?php
    include_once 'everywhere/footer.php'
    ?>
</body>