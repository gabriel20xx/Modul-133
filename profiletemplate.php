<?php
include_once '../includes/connect-db.php';
include_once '../everywhere/header.php';
?>

<body>
  <?php
  include_once '../everywhere/navbar.php';
  ?>

  <?php
  $uuid = basename(__FILE__, '.php');

  $sql = "SELECT * FROM users WHERE uuid = '$uuid'";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);

  if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $username = $row['username'];
      $email = $row['email'];
      $password = $row['password'];
    }
  }
  ?>

  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="text-center">
          <img src="https://via.placeholder.com/150" class="rounded-circle" alt="Profile Picture">
          <h2><?php echo $username ?></h2>
          <p><?php echo $email ?></p>
        </div>
        <hr>
        <form action="../includes/edit-user.php" method="post">
          <div class='errors'>
            <?php
            if (isset($_GET["error"])) {
              if ($_GET["error"] == "notloggedin") {
                echo
                '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertBox">
                    You are not logged in!
                    <button type="button" class="btn-close" aria-label="Close"></button>
                    </div>';
              } else if ($_GET["error"] == "notauthorized") {
                echo
                '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertBox">
                    You are not authorized to do this action!
                    <button type="button" class="btn-close" aria-label="Close"></button>
                    </div>';
              }
            }
            ?>
          </div>
          <input type='hidden' name='uuid' value='<?php echo $uuid ?>'>
          <div class="form-group mb-2">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" disabled>
          </div>
          <div class="form-group mb-2">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" disabled>
          </div>
          <?php if (isset($_SESSION['uuid']) && $_SESSION['uuid'] == $uuid) : ?>
            <div class="form-group mb-2">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>" disabled>
            </div>
            <div class="text-right">
              <button type="button" class="btn btn-primary" name="edit" id="edit-btn">Edit</button>
              <button type="submit" class="btn btn-success d-none" name="submit" id="save-btn">Save</button>
              <button type="button" class="btn btn-danger" id="delete-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete Account</button>
            </div>
          <?php endif; ?>
        </form>

      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">User deletion</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete your account? This action cannot be undone.
        </div>
        <div class="modal-footer">
          <form action="../includes/delete-user.php" method="post">
            <input type='hidden' name='uuid' value='<?php echo $uuid ?>'>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-danger">Understood</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="../js/profile.js"></script>

  <?php
  include_once '../everywhere/footer.php';
  ?>