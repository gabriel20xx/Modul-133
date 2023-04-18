<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
?>

<?php
if (isset($_GET["page"])) {
    $currentPage = $_GET["page"];
} else {
    $currentPage = 1;
}
?>

<body>
    <?php
    include_once 'everywhere/navbar.php';
    ?>
    <div class='container'>
        <div class='errors'>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "postcreated") {
                    echo
                    '<div class="alert alert-success" role="alert">
                Post successfully created!
                </div>';
                } else if ($_GET["error"] == "postdeleted") {
                    echo
                    '<div class="alert alert-danger" role="alert">
                Post deleted!
                </div>';
                }
            }
            ?>
        </div>
        <h1 class="display-4 text-center">Forum</h1>
        <div class="dropdowns-container d-flex justify-content-between">
  <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter by category
            </button>
            <ul class="dropdown-menu">
                <?php
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

                                echo "<li><a class='dropdown-item' href='#'>$name</a></li>";
                            }
                        }
                    }
                    ?>
            </ul>
            </div>

        <?php
        if (isset($_SESSION["uuid"])) {
            echo '    
    <div class="text-center mt-5">
    <div>
    <a class="btn btn-lg btn-success" href="new_blog.php" role="button">Create new post</a>
    </div>    
    </div>';
        }
        ?>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sort by
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">A-Z</a></li>
                <li><a class="dropdown-item" href="#">Z-A</a></li>
                <li><a class="dropdown-item" href="#">Created asc</a></li>
                <li><a class="dropdown-item" href="#">Created desc</a></li>
                <li><a class="dropdown-item" href="#">User asc</a></li>
                <li><a class="dropdown-item" href="#">User desc</a></li>
            </ul>
        </div>
        </div>

        <!-- Grid overview -->

        <div class="row mb-3 p-5 text-center">
            <?php
            $sql = "SELECT COUNT(*) as count FROM blogs";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $count = $row["count"];

                if ($count > 12) {
                    $count = 12;
                }

                for ($i = 0; $i < $count; $i++) {
                    $sql = "SELECT * FROM blogs ORDER BY createdAt DESC LIMIT 1 OFFSET " . $i;
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);

                    if ($resultCheck > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $uuid = $row['uuid'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $category_id = $row['category_id'];
                        $createdBy = $row['user_uuid'];
                        $date1 = $row['createdAt'];
                        $date2 = date('Y-m-d H:i:s');
                        $diff = abs(strtotime($date2) - strtotime($date1));

                        $years = floor($diff / (365 * 60 * 60 * 24));
                        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
                        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
                        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

                        if ($years == 0) {
                            if ($months == 0) {
                                if ($days == 0) {
                                    if ($hours == 0) {
                                        if ($minutes == 0) {
                                            $timeago = $seconds . ' seconds';
                                        } else {
                                            $timeago = $minutes . ' minutes';
                                        }
                                    } else {
                                        $timeago = $hours . ' hours';
                                    }
                                } else {
                                    $timeago = $days . ' days';
                                }
                            } else {
                                $timeago = $months . ' months';
                            }
                        } else {
                            $timeago = $years . ' years';
                        }

                        $createdByUser = "SELECT * FROM users WHERE uuid = '$createdBy'";
                        $result2 = mysqli_query($conn, $createdByUser);
                        $resultCheck2 = mysqli_num_rows($result2);

                        if ($resultCheck2 > 0) {
                            $row2 = mysqli_fetch_assoc($result2);
                            $username = $row2['username'];
                        }

                        $sql = "SELECT * FROM categories WHERE id = '$category_id'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);

                        if ($resultCheck > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $category = $row['name'];
                        }

                        echo "<div class='col-md-4 g-4 mg-4 p-0 card'>
                        <div class='card-header'>$username</div>
                        <div class='card-body'>
                            <h5 class='card-title'>$title</h5>
                            <p class='card-text'>$description</p>
                            <p class='card-text'>$category</p>
                            <a href='blogs/$uuid.php' class='btn btn-primary'>Go to article</a>
                        </div>
                        <div class='card-footer text-muted'>$timeago ago</div>
                    </div>";
                    }
                }
            }
            ?>

        </div>

        <?php
        if ($currentPage != 1) {
            $previousPage = $currentPage - 1;
        } else {
            $previousPage = "None";
        }

        if ($count > 12 * ($currentPage)) {
            $nextPage = $currentPage + 1;
        } else {
            $nextPage = "None";
        }
        ?>

        <div>
            <ul class="pagination justify-content-center">
                <?php
                if ($count > 12 && $currentPage != 1) {
                    echo "<li class='page-item'>
                  <a class='page-link' href='forum.php?page=$previousPage' aria-label='Previous'>
                      <span aria-hidden='true'>«</span>
                  </a>
                </li>
                
                <li class='page-item'><a class='page-link' href='forum.php?page=$previousPage'>$previousPage</a></li>";
                }

                echo "<li class='page-item'><a class='page-link' href='forum.php?page=$currentPage'>$currentPage</a></li>";

                if ($count > 12 * ($currentPage)) {
                    echo "<li class='page-item'><a class='page-link' href='forum.php?page=$nextPage'>$nextPage</a></li>

                  <li class='page-item'>
                  <a class='page-link' href='forum.php?page=$nextPage' aria-label='Next'>
                      <span aria-hidden='true'>»</span>
                  </a>
                </li>";
                }
                ?>
            </ul>
        </div>

        <?php
        include_once 'everywhere/footer.php';
        ?>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2.10.3/dist/umd/popper.min.js"></script>
<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

