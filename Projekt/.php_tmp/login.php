<?php 
#include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
?>

<body class="text-center login-page">

    <!-- Insert Login Code here-->
    <main class="form-signin w-100 m-auto">
    <form action="/login.php" method="post">
        <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="logo" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
        <input type="email" class="form-control form-first" id="email" placeholder="name@example.com">
        <label for="email">Email address</label>
        </div>
        <div class="form-floating">
        <input type="password" class="form-control form-last" id="password" placeholder="Password">
        <label for="password">Password</label>
        </div>

        <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        </div>
        <button class="w-100 btn btn-lg mb-3 btn-primary" type="submit">Sign in</button>
        <a href="register.php">
        <div class="w-100 btn btn-lg btn-secondary">Go to register</div>
        </a>
        <p class="mt-5 mb-3 text-muted">&copy; Gabriel, Cornel, Till 2023</p>
    </form>
    <div class="errors">
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo 
            '<div class="alert alert-danger" role="alert">
            Fill in all fields!
            </div>';
        }
        else if ($_GET["error"] == "wronglogin") {
            echo 
            '<div class="alert alert-danger" role="alert">
            Incorrect Login information!
            </div>';
        }
    }
    ?>
</div>
    </main>


    <?php
    include_once 'everywhere/footer.php';
    ?>
</body>