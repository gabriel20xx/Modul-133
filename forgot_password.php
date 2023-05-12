<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
include_once 'everywhere/navbar.php';
?>

<!-- Reset Password Content -->
<div class="text-center login-page">
    <main class="form-signin w-100 m-auto">
        <form action="includes/forgot-password.php" method="post">
            <img class="mb-4" src="pictures/LogoGCT.png" alt="LogoGTC" width="200px">
            <h1 class="h3 mb-3 fw-normal">Reset password</h1>

            <!-- Alert Boxes -->
            <div class="errors">
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertBox">
                            Fill in all fields!
                            <button type="button" class="btn-close" aria-label="Close"></button>
                            </div>';
                    }
                }
                ?>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder="name@example.com">
                <label for="username">Email address</label>
            </div>
            <button class="w-100 btn btn-lg mb-3 btn-primary" name="submit" type="submit">Reset password</button>
            <a href="login.php">
                <div class="w-100 btn btn-lg btn-secondary">Go back to login</div>
            </a>
            <p class="mt-5 mb-3 text-muted"><?php include_once 'everywhere/footer.php'; ?></p>
        </form>
    </main>
</div>
</body>