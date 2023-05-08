<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
include_once 'everywhere/navbar.php';
?>

<?php
if (isset($_GET["page"])) {
    $currentPage = $_GET["page"];
} else {
    $currentPage = 1;
}
?>

<div class='container'>
    <div class='errors'>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "postcreated") {
                echo
                '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alertBox">
                Post successfully created!
                <button type="button" class="btn-close" aria-label="Close"></button>
                </div>';
            } else if ($_GET["error"] == "postdeleted") {
                echo
                '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertBox">
                Post deleted!
                <button type="button" class="btn-close" aria-label="Close"></button>
                </div>';
            }
        }
        ?>
    </div>
    <h1 class="display-4 text-center">Forum</h1>
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
    <div class="dropdowns-container d-flex justify-content-between">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                if (isset($_GET["category"])) {
                    $category = $_GET["category"];

                    if ($category == "all") {
                        $category_sql = "";
                    } else {

                        $sql = "SELECT * FROM categories WHERE name = '$category'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);

                        if ($resultCheck > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $category_id = $row['id'];
                            $category_sql = "WHERE category_id ='$category_id'";
                        }
                    }
                    echo "Filter by $category";
                } else {
                    $category_sql = "";
                    echo "Filter by category";
                }
                ?>
            </button>
            <ul class="dropdown-menu">
                <?php
                echo "<li><a class='dropdown-item' href='?" . http_build_query(array_merge($_GET, array('category' => 'all'))) . "'>Everything</a></li>";
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

                            echo "<li><a class='dropdown-item' href='?" . http_build_query(array_merge($_GET, array('category' => $name))) . "'>$name</a></li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                if (isset($_GET["sort"])) {
                    if ($_GET["sort"] == "a-z") {
                        $sort_sql = "A-Z";
                        $sort = "title ascending";
                    } else if ($_GET["sort"] == "z-a") {
                        $sort_sql = "Z-A";
                        $sort = "title descending";
                    } else if ($_GET["sort"] == "created-asc") {
                        $sort_sql = "createdAt ASC";
                        $sort = "created ascending";
                    } else if ($_GET["sort"] == "created-desc") {
                        $sort_sql = "createdAt DESC";
                        $sort = "created descending";
                    } else if ($_GET["sort"] == "user-asc") {
                        $sort_sql = "user_uuid ASC";
                        $sort = "user ascending";
                    } else if ($_GET["sort"] == "user-desc") {
                        $sort_sql = "user_uuid DESC";
                        $sort = "user descending";
                    }
                    echo "Sort by $sort";
                } else {
                    $sort_sql = "createdAt DESC";
                    $sort = "created descending";
                    echo "Sort by $sort";
                }
                ?>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, array('sort' => 'a-z'))) ?>">A-Z</a></li>
                <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, array('sort' => 'z-a'))) ?>">Z-A</a></li>
                <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, array('sort' => 'created-asc'))) ?>">Created asc</a></li>
                <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, array('sort' => 'created-desc'))) ?>">Created desc</a></li>
                <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, array('sort' => 'user-asc'))) ?>">User asc</a></li>
                <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, array('sort' => 'user-desc'))) ?>">User desc</a></li>
            </ul>
        </div>
    </div>

    <!-- Grid overview -->

    <div class="row mb-3 p-2 text-center">
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
                $sql = "SELECT * FROM blogs $category_sql ORDER BY $sort_sql LIMIT 1 OFFSET " . $i;
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

                    echo "<div class='col-md-4 p-0'>
                        <div class='m-2 card'>
                        <div class='card-header'><a href='profiles/$createdBy.php'>$username</a></div>
                        <div class='card-body'>
                            <h5 class='card-title'>" . substr($title, 0, 30) . "</h5>
                            <p class='card-text'>" . substr($description, 0, 50) . " ...</p>
                            <a href='blogs/$uuid.php' class='btn btn-primary'>Go to article</a>
                        </div>
                        <div class='card-footer text-muted'><a href='?" . http_build_query(array_merge($_GET, array('category' => $category))) . "'>$category</a></div>
                        <div class='card-footer text-muted'>$timeago ago</div>
                    </div>
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
                <a class='page-link' href='?" . http_build_query(array_merge($_GET, array('page' => $previousPage))) . "' aria-label='Previous'>
                    <span aria-hidden='true'>«</span>
                </a>
            </li>
            
            <li class='page-item'><a class='page-link' href='?" . http_build_query(array_merge($_GET, array('page' => $previousPage))) . "'>$previousPage</a></li>";
            }

            echo "<li class='page-item'><a class='page-link' href='?" . http_build_query(array_merge($_GET, array('page' => $currentPage))) . "'>$currentPage</a></li>";

            if ($count > 12 * ($currentPage)) {
                echo "<li class='page-item'><a class='page-link' href='?" . http_build_query(array_merge($_GET, array('page' => $nextPage))) . "'>$nextPage</a></li>

            <li class='page-item'>
                <a class='page-link' href='?" . http_build_query(array_merge($_GET, array('page' => $nextPage))) . "' aria-label='Next'>
                    <span aria-hidden='true'>»</span>
                </a>
            </li>";
            }
            ?>
        </ul>
    </div>
</div>

<?php
include_once 'everywhere/footer.php';
?>

<!--  JavaScript
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.10.3/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script> -->