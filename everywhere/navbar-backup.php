<!-- <nav class="navbar navbar-expand-md bg-body-tertiary">
  <div class="container align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none navbar-brand" href="../index.php">
      <img src="../pictures/tbzlogo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse nav col-12 col-md-auto mb-2 justify-content-center mb-md-0" id="navbarNav">
      <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../forum.php">Forum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../about.php">About</a>
          </li>
      </ul>
    </div>
    <div class='col-md-3 text-end' id="navbarNav">
      <?php /* if(isset($_SESSION["username"])) {
        echo "
        <a class='btn btn-outline-primary me-2' href='../includes/logout.php'>Logout</a>
        <a class='btn btn-primary' href='../profiles/".$_SESSION["id"].".php'>Profile</a>
        ";
      } else {
        echo "
        <a class='btn btn-outline-primary me-2' href='../login.php'>Login</a>
        <a class='btn btn-primary' href='../register.php'>Register</a>
        ";
      } */
      ?>
    </div>
  </div>
</nav> -->
<!-- <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <img class="bi me-2" src="../pictures/tbzlogo.png" alt="Logo" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></img>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Forum</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
      </ul>

      <div class="col-md-3 text-end">
        <button type="button" class="btn btn-outline-primary me-2"><a href="https://www.example.com/login">Login</a></button>
        <button type="button" class="btn btn-primary"><a href="https://www.example.com/login">Register</a></button>
      </div>
    </header>
  </div> -->

  <nav class="navbar navbar-expand-md bg-body-tertiary">
  <div class="container align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none navbar-brand" href="../index.php">
      <img src="../pictures/tbzlogo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse nav col-12 col-md-auto mb-2 justify-content-center mb-md-0" id="navbarNav">
      <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../forum.php">Forum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../about.php">About</a>
          </li>
      </ul>
    </div>
    <div class='col-md-3 text-end d-none d-md-block'>
      <?php if(isset($_SESSION["username"])) {
        echo "
        <a class='btn btn-outline-primary me-2' href='../includes/logout.php'>Logout</a>
        <a class='btn btn-primary' href='../profiles/".$_SESSION["id"].".php'>Profile</a>
        ";
      } else {
        echo "
        <a class='btn btn-outline-primary me-2' href='../login.php'>Login</a>
        <a class='btn btn-primary' href='../register.php'>Register</a>
        ";
      }
      ?>
    </div>
  </div>
</nav>