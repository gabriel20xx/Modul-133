<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
include_once 'everywhere/navbar.php';
?>

<div class="text-center login-page">
    <main class="form-signin w-100 m-auto">
        <form action="includes/login.php" method="post">
            <img class="mb-4" src="pictures/LogoGCT.png" alt="LogoGTC" width="200px">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <!-- Alert Boxes -->
            <div class="errors">
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo
                        '<div class="alert alert-danger" role="alert">
                Fill in all fields!
                </div>';
                    } else if ($_GET["error"] == "wronglogin") {
                        echo
                        '<div class="alert alert-danger" role="alert">
                Incorrect Login information!
                </div>';
                    }
                }
                ?>
            </div>

            <div class="form-floating">
                <input type="text" name="username" class="form-control form-first" id="username" placeholder="name@example.com">
                <label for="username">Username or Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control form-last" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input name="remember-me" type="checkbox" value="1"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg mb-3 btn-primary" name="submit" type="submit">Sign in</button>
            <a href="register.php">
                <div class="w-100 btn btn-lg mb-3 btn-secondary">Go to register</div>
            </a>
            <a href="forgot_password.php">Forgot password?</a>
            <p class="mt-5 mb-3 text-muted"><?php include_once 'everywhere/footer.php'; ?></p>
        </form>
    </main>
</div>
</body>