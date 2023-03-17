<?php 
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
?>

<body>
    <?php
        include_once 'everywhere/navbar.php'
    ?>
    <div class="text-center login-page">
    <!-- Insert Register Code here-->
    <main class="form-signin w-100 m-auto">
    <form action="includes/register.php" method="post">
    <img class="mb-4" src="pictures/LogoGCT.png" alt="LogoGTC" width="200px">
        <h1 class="h3 mb-3 fw-normal">Please register</h1>

        <div class='errors'>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Fill in all fields!
                </div>';
            }
            else if ($_GET["error"] == "invalidusername") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Username not valid!
                </div>';
            }
            else if ($_GET["error"] == "invalidemail") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Email not valid!
                </div>';
            }
            else if ($_GET["error"] == "passwordsdontmatch") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Passwords dont match!
                </div>';
            }
            else if ($_GET["error"] == "usernametaken") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Username is already taken!
                </div>';
            }
            else if ($_GET["error"] == "stmtfailed") {
                echo 
                '<div class="alert alert-danger" role="alert">
                Something went wrong!
                </div>';
            }
            else if ($_GET["error"] == "none") {
                echo 
                '<div class="alert alert-success" role="alert">
                You have signed up!
                </div>';
            }
        }
    ?>
    </div>

        <div class="form-floating">
        <input type="text" name="username" class="form-control form-first" id="username" placeholder="Username">
        <label for="username">Username</label>
        </div>
        <div class="form-floating">
        <input type="email" name="email" class="form-control form-middle" id="email" placeholder="name@example.com">
        <label for="email">Email address</label>
        </div>
        <div class="form-floating">
        <input type="password" name="password" class="form-control form-middle" id="password" placeholder="Password">
        <label for="password">Password</label>
        </div>
        <div class="form-floating mb-3">
        <input type="password" name="password_rep" class="form-control form-last" id="password_rep" placeholder="Repeat Password">
        <label for="password_rep">Repeat Password</label>
        </div>
        <button class="w-100 mb-3 btn btn-lg btn-primary" name="submit" type="submit">Register</button>
        <a href="login.php">
        <div class="w-100 btn btn-lg btn-secondary">Go to login</div>
        </a>
        <p class="mt-5 mb-3 text-muted">&copy; Gabriel, Cornel, Till 2023</p>
    </form>
    
    </main>
    </div>

    <?php
/*     include_once 'everywhere/footer.php'; */
    ?>
</body>