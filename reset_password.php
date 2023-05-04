<?php
include_once 'includes/connect-db.php';
include_once 'everywhere/header.php';
?>

<body>
    <?php
    include_once 'everywhere/navbar.php'
    ?>
    <div class="text-center login-page">
        <!-- Insert Login Code here-->
        <main class="form-signin w-100 m-auto">
            <form action="includes/reset-password.php" method="post">
                <img class="mb-4" src="pictures/LogoGCT.png" alt="LogoGTC" width="200px">
                <h1 class="h3 mb-3 fw-normal">Reset password</h1>

                <div class="errors">
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertBox">
                            Fill in all fields!
                            </div>';
                        }
                    }
                    ?>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" class="form-control form-middle" id="password" placeholder="Password">
                    <label for="password">New password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password_rep" class="form-control form-last" id="password_rep" placeholder="Repeat Password">
                    <label for="password_rep">Repeat new password</label>
                </div>
                <button class="w-100 btn btn-lg mb-3 btn-primary" name="submit" type="submit">Reset password</button>
                <p class="mt-5 mb-3 text-muted"><?php include_once 'everywhere/footer.php'; ?></p>
            </form>
        </main>
    </div>
</body>