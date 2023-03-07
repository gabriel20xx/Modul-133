<?php 
#include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
    ?>

    <!-- Insert Homepage Code here-->
    <h1>Dies ist die Forumpage</h1>

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

    <!-- Grid overview -->

    <div class="row mb-3 p-5 text-center">
        <?php for ($i = 0; $i <= 10; $i++) {
            $sql = "SELECT * FROM blogs WHERE id = $i";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['title'];
                    $description = $row['description'];
                    echo 
                    "<div class='col-md-4 g-4 mg-4 p-0 card'>
                    <div class='card-header'>
                    Author
                    </div>
                    <div class='card-body'>
                    <h5 class='card-title'>$title</h5>
                    <p class='card-text'>$description</p>
                    <a href='#' class='btn btn-primary'>Go to article</a>
                    </div>
                    <div class='card-footer text-muted'>
                    2 days ago
                    </div>
                    </div>";
                }
            }
        }
        ?>
    </div>

    <div>
        <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">«</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">»</span>
              </a>
        </li>
    </ul>
    </div>
    

    <?php
    include_once 'everywhere/footer.php'
    ?>
