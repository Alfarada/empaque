<?php

require_once '../helpers/helper.php';

session_start();

if (isset($_SESSION['user'])) {
    require '../views/content.php';
} else {
    header('Location: login.php');
}

?>