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
      <p class="lead">
        In our forum you will find different categories tailored to different interests. For example, you can find out about the latest developments in medicine or discuss the latest trends and games with other gaming enthusiasts. We also cover topics such as the environment, politics and society. If you have questions or problems, you can always ask for our help and support. Our moderators are always there for you and are happy to help.
      </p>
      <p class="lead">
        We also offer regular events and challenges where you can put your knowledge and skills to the test. Whether it's a quiz, a survey or a creative task - there's something for everyone. So what are you waiting for? Register now and become part of our community!
      </p>
      <hr class="my-4">
      <p>Explore our forums, create your own topics, and engage in discussions with other members of our community.</p>
      <a class="btn btn-primary btn-lg" href="#" role="button">Get Started</a>
      <img src="picutres/communicatie.png" class="img-fluid" alt="Responsive image">
    </div>
    <div class="row">
      <div class="col-lg-4">
        <h2>Forum Categories</h2>
        <ul class="list-group">
          <li class="list-group-item"><a href="#">General Discussion</a></li>
          <li class="list-group-item"><a href="#">News and Announcements</a></li>
          <li class="list-group-item"><a href="#">Technical Support</a></li>
          <li class="list-group-item"><a href="#">Suggestions and Feedback</a></li>
          <li class="list-group-item"><a href="#">Off-Topic Discussion</a></li>
        </ul>
      </div>
      <div class="col-lg-8">
        <h2>Recent Topics</h2>
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Topic 1</h5>
              <small>3 days ago</small>
            </div>
            <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Topic 2</h5>
              <small>1 week ago</small>
            </div>
            <p class="mb-1">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Topic 3</h5>
              <small>2 weeks ago</small>
            </div>
            <p class="mb-1">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
          </a>
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