<?php 
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
?>

<?php
if (isset($_GET["page"])) {
        $currentPage = $_GET["page"];
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
            }
            else if ($_GET["error"] == "postdeleted") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Post deleted!
                </div>';
            }
        }
        ?>
    </div>

    <!-- Carroussel -->
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style="max-height: 500px;">
            <div class="carousel-item active">
            <img src="pictures/placeholder.jpg" class="d-block w-100 img-fluid" alt="...">
            </div>
            <div class="carousel-item">
            <img src="pictures/placeholder.jpg" class="d-block w-100 img-fluid" alt="...">
            </div>
            <div class="carousel-item">
            <img src="pictures/placeholder.jpg" class="d-block w-100 img-fluid" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class='text-center mt-5'>
    <?php
    if (isset($_SESSION["uuid"])) {
    echo '<div>
    <a class="btn btn-lg btn-success" href="new_blog.php" role="button">Create new post</a>
    </div>';
    }
    ?>
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
            $newcount = 12;
        }

        for ($i = 0; $i < $newcount; $i++) {
            $sql = "SELECT * FROM blogs ORDER BY createdAt DESC LIMIT 1 OFFSET " . (($currentPage-1) * 12 + $i);
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                $row = mysqli_fetch_assoc($result);
                $title = $row['title'];
                $link = $row['uuid'];
                $description = $row['description'];
                $date1 = $row['createdAt'];
                $date2 = date('Y-m-d H:i:s');
                $diff = abs(strtotime($date2) - strtotime($date1));
            
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
                $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
                $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
                
                if ($years == 0){
                    if ($months == 0){
                        if ($days == 0){
                            if ($hours == 0){
                                if ($minutes == 0){
                                    $timeago = $seconds.' seconds';
                                } else {
                                    $timeago = $minutes.' minutes';
                                }
                            } else {
                                $timeago = $hours.' hours';
                            }
                        } else {
                            $timeago = $days.' days';
                        }
                    } else {
                        $timeago = $months.' months';
                    }      
                } else {
                    $timeago = $years.' years';
                }

                $createdBy = $row['user_uuid'];
                $createdByUser = "SELECT * FROM users WHERE uuid = '$createdBy'";
                $result2 = mysqli_query($conn, $createdByUser);
                $resultCheck2 = mysqli_num_rows($result2);

                if ($resultCheck2 > 0) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $username = $row2['username'];
                
                echo "<div class='col-md-4 g-4 mg-4 p-0 card'>
                    <div class='card-header'>$username</div>
                    <div class='card-body'>
                        <h5 class='card-title'>$title</h5>
                        <p class='card-text'>$description</p>
                        <a href='blogs/$link.php' class='btn btn-primary'>Go to article</a>
                    </div>
                    <div class='card-footer text-muted'>$timeago ago</div>
                </div>";
                }
            }
        }
    }
    ?>

    </div>

    <?php
    if ($currentPage != 1) {
        $previousPage = $currentPage-1;
    } else {
        $previousPage = "None";
    }

    if ($count > 12*($currentPage+1)) {
        $nextPage = $currentPage+1;
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

        if ($count > 12*($currentPage+1)) {
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
    


