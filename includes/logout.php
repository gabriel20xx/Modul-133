<?php

require_once 'functions.php';

logoutUser();
header("Location: ../index.php?error=loggedout");
exit;
