<?php

require_once '../helpers/helper.php';

session_start();

if (isset($_SESSION['email'])) {
    require '../views/content.php';
} else {
    header('Location: login.php');
}

// require '../views/content.php';

?>