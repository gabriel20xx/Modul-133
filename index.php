<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php'
?>

<body>
  <?php
  include_once 'everywhere/navbar.php'
  ?>
  <div class="container">
    <div class='errors'>
      <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "loggedin") {
          echo
          '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alertBox">
                You logged in successfully!
                <button type="button" class="btn-close" aria-label="Close"></button>
                </div>';
        }
      }
      ?>
    </div>

    <!-- Insert Homepage Code here-->
    <div class="jumbotron mt-4">
      <h1 class="display-4">Welcome to The GCT Corner!</h1>
      <img src="pictures/communicate.png" class="img-fluid" alt="Responsive image">
      <h2 class="display-4">Our offer!</h2>
      <p class="lead">
        In our forum you will find different categories tailored to different interests. For example, you can find out about the latest developments in medicine or discuss the latest trends and games with other gaming enthusiasts. We also cover topics such as the environment, politics and society. If you have questions or problems, you can always ask for our help and support. Our moderators are always there for you and are happy to help.
      </p>
      <p class="lead">
        We also offer regular events and challenges where you can put your knowledge and skills to the test. Whether it's a quiz, a survey or a creative task - there's something for everyone. So what are you waiting for? Register now and become part of our community!
      </p>
      <hr class="my-4">
      <p>Explore our forums, create your own topics, and engage in discussions with other members of our community.</p>
      <a class="btn btn-primary btn-lg" href="#" role="button">Get Started</a>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <h2>Forum Categories</h2>
        <ul class="list-group">
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
                $name = $row['name'];

                echo "<li class='list-group-item'>$name</li>";
              }
            }
          }
          ?>

        </ul>
      </div>
      <div class="col-lg-8">
        <h2>Recent Topics</h2>
        <div class="list-group">
          <?php
          $sql = "SELECT COUNT(*) as count FROM blogs";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $count = $row["count"];

            if ($count > 5) {
              $count = 5;
            }

            for ($i = 0; $i < $count; $i++) {
              $sql = "SELECT * FROM blogs LIMIT 1 OFFSET " . $i;
              $result = mysqli_query($conn, $sql);
              $resultCheck = mysqli_num_rows($result);

              if ($resultCheck > 0) {
                $row = mysqli_fetch_assoc($result);
                $uuid = $row['uuid'];
                $title = $row['title'];
                $description = $row['description'];
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

                echo "
          <a href='blogs/$uuid.php' class='list-group-item list-group-item-action'>
            <div class='d-flex w-100 justify-content-between'>
              <h5 class='mb-1'>$title</h5>
              <small>$timeago ago</small>
            </div>
            <p class='mb-1'>$description</p>
          </a>
      
      ";
              }
            }
          }
          ?>

        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6">
        <h2>About Us</h2>
        <p>We are a community of people who love to explore new technologies and share our knowledge with others.</p>
      </div>
      <div class="col-md-6">
        <h2>Latest News</h2>
        <ul>
          <li>Introducing our new website design</li>
          <li>Join our upcoming webinar on AI and Machine Learning</li>
          <li>Our team won first prize in a hackathon competition</li>
        </ul>
      </div>
    </div>

    <!-- Call to action section -->
    <div class="row mt-3">
      <div class="col-12 text-center">
        <a href="#" class="btn btn-primary">Join Us Now</a>
      </div>
    </div>

    <!-- Footer section -->

  </div>

  <?php
  include_once 'everywhere/footer.php'
  ?>
</body>