<div class="container">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
      <a class="navbar-brand" href="../index.php" class="d-inline-flex link-body-emphasis text-decoration-none" height="42px">
        <img src="../pictures/LogoGCT.png" alt="LogoGTC" height="42px">
      </a>
    </div>

    <ul class="navbar-nav nav d-flex flex-row col-12 col-md-auto mb-2 justify-content-center mb-md-0 ">
      <li class="nav-item"><a href="../index.php" class="nav-link px-2 active">Home</a></li>
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