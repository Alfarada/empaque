<?php

require 'helpers/helper.php';

session_start();

if (isset($_SESSION['user'])) {
    header('Location: controllers/content.php');
} else {
    header('Location: controllers/register.php');
}

