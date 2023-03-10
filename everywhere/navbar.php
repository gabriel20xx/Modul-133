<nav class="navbar navbar-expand-sm bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <img src="../pictures/tbzlogo.png" alt="Logo">
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
          <a class="nav-link" href="../profile.php">Forum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../about.php">About</a>
        </li>
      </ul>
      <ul class="navbar-nav">
      <?php if(isset($_SESSION["username"])) {
        echo "
          <li class='nav-item w-300 me-2'>
            <a class='nav-link btn btn-outline-primary nav-button-login' href='../includes/logout.php'>Logout</a>
          </li>
          <li class='nav-item w-300'>
            <a class='nav-link btn btn-primary nav-button-register' href='../profiles/".$_SESSION["id"].".php'>Profile</a>
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
</nav>