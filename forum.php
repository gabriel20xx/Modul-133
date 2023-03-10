<?php 
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
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
        
        for ($i = 0; $i < $count; $i++) {
            $sql = "SELECT * FROM blogs ORDER BY createdAt DESC LIMIT $i, 1";
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
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
                $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

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
                        <div class='card-footer text-muted'>$years years, $months months, $days days, $hours hours, $minutes minutes, $seconds seconds ago</div>
                    </div>";
                }
            }
        }
    }
    ?>

    </div>

    <div>
        <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">??</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">??</span>
              </a>
        </li>
    </ul>
    </div>
    <?php
    include_once 'everywhere/footer.php'
    ?>
</div>
    


