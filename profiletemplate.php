<?php
include_once '../includes/connect-db.php';
include_once '../everywhere/header.php';
?>

<body>
  <?php
  include_once '../everywhere/navbar.php';
  ?>

  <?php
  // Here you would typically include any PHP code required to retrieve the user's data from a database or session
  // For this example, we'll just use hardcoded values
  $filename = basename(__FILE__, '.php');

  $sql = "SELECT * FROM users WHERE uuid = '$filename'";
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
        <form>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" disabled>
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" disabled>
          </div>
          <?php
          if (isset($_SESSION['uuid']) && $_SESSION['uuid'] == $filename) {
            echo "<form method='post' action=''>
        <div class='form-group'>
          <label for='password'>Password</label>
          <input type='password' class='form-control' id='password' name='password' value='<?php echo $password ?>' disabled>
        </div>
        <div class='text-right'>
          <button type='submit' class='btn btn-primary' name='edit' onclick=\"this.form.action='includes/edit-user.php';\">Edit</button>
          <button type='submit' class='btn btn-success d-none' id='save-btn'>Save</button>
          <button type='submit' class='btn btn-danger' name='delete' onclick=\"confirmDelete();\">Delete Account</button>
        </div>
      </form>";
          }
          ?>

        </form>
      </div>
    </div>
  </div>



  <?php
  include_once '../everywhere/footer.php';
  ?>

  <script>
    var editBtn = document.getElementById("edit-btn");
    var saveBtn = document.getElementById("save-btn");
    var deleteBtn = document.getElementById("delete-btn");
    var usernameInput = document.getElementById("username");
    var emailInput = document.getElementById("email");
    var passwordInput = document.getElementById("password");

    // Enable form inputs and show/hide buttons on edit click
    editBtn.addEventListener("click", function() {
      editBtn.classList.add("d-none");
      saveBtn.classList.remove("d-none");
      deleteBtn.classList.add("d-none");
      usernameInput.disabled = false;
      emailInput.disabled = false;
      passwordInput.disabled = false;
    });

    // Disable form inputs and show/hide buttons on save click
    saveBtn.addEventListener("click", function() {
      editBtn.classList.remove("d-none");
      saveBtn.classList.add("d-none");
      deleteBtn.classList.remove("d-none");
      usernameInput.disabled = true;
      emailInput.disabled = true;
      passwordInput.disabled = true;
    });

    // Show confirmation dialog on delete click
    function confirmDelete() {
      if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        // Here you would typically include any PHP code required to delete the user's account from a database or session
        // Create a new XMLHttpRequest object
/*         var xhttp = new XMLHttpRequest();

        // Define the function to be executed when the response is received
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // The response is ready and the status code is 200 (OK)
            console.log(this.responseText); // Do something with the file's contents
          }
        };

        // Send the request to the server
        xhttp.open("POST", "includes/delete-user.php", true); // Replace "path/to/file.txt" with the actual file path
        xhttp.send(); */
        this.form.action='includes/delete-user.php';
        
        alert("Account deleted successfully.");
        window.location.href = "../index.php"; // Redirect to home page or login page
      }
    }
  </script>
</body>