<nav class="navbar navbar-expand-md bg-body-tertiary mb-4">
  <div class="container">
    <a class="navbar-brand" href="../index.php" height="42px">
      <img src="../pictures/LogoGCT.png" alt="LogoGTC" height="42px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../forum.php">Forum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../about.php">About</a>
        </li>
        <?php if (isset($_SESSION["uuid"])) { ?>
          <li class="nav-item">
            <a class="nav-link" href="../profiles/<?php echo $_SESSION["uuid"]; ?>.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../includes/logout.php">Logout</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="../login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../register.php">Register</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>