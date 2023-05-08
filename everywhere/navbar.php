<!-- <nav class="navbar navbar-expand-md bg-body-tertiary mb-4">
  <div class="container">
    <a class="navbar-brand" href="../index.php" height="42px">
      <img src="../pictures/LogoGCT.png" alt="LogoGTC" height="42px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
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
      <ul class="navbar-nav">
        <?php if (isset($_SESSION["uuid"])) {
          echo "
          <li class='nav-item w-300 me-2'>
            <a class='nav-link btn btn-outline-primary nav-button-login' href='../includes/logout.php'>Logout</a>
          </li>
          <li class='nav-item w-300'>
            <a class='nav-link btn btn-primary nav-button-register' href='../profiles/" . $_SESSION["uuid"] . ".php'>Profile</a>
          </li>";
        } else {
          echo "
          <li class='nav-item w-300 me-2'>
            <a class='nav-link btn btn-outline-primary nav-button-login' href='../login.php'>Login</a>
          </li>
          <li class='nav-item w-300'>
            <a class='nav-link btn btn-primary nav-button-register' href='../register.php'>Register</a>
          </li>";
        } ?>
      </ul>
    </div>
  </div>
</nav> -->

<div class="container">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
      <a class="navbar-brand" href="../index.php" class="d-inline-flex link-body-emphasis text-decoration-none" height="42px">
        <img src="../pictures/LogoGCT.png" alt="LogoGTC" height="42px">
      </a>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 navbar-nav">
      <li class="nav-item"><a href="../index.php" class="nav-link px-2 link-secondary active">Home</a></li>
      <li class="nav-item"><a href="../forum.php" class="nav-link px-2">Forum</a></li>
      <li class="nav-item"><a href="../about.php" class="nav-link px-2">About</a></li>
      <li class="nav-item"><a href="../impressum.php" class="nav-link px-2">Impressum</a></li>
    </ul>

    <div class="col-md-3 text-end">
      <?php if (isset($_SESSION["uuid"])) {
        echo "
        <a href='../includes/logout.php'>
        <button type='button' class='btn btn-outline-primary me-2'>Logout</button>
        </a>
        <a href='../profiles/" . $_SESSION["uuid"] . ".php'>
        <button type='button' class='btn btn-primary'>Profile</button>
        </a>";
      } else {
        echo "
        <a href='../includes/login.php'>
        <button type='button' class='btn btn-outline-primary me-2'>Login</button>
        </a>
        <a href='../includes/register.php'>
        <button type='button' class='btn btn-primary'>Register</button>
        </a>";
      } ?>
    </div>
  </header>
</div>