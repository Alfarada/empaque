<?php

session_start();

session_destroy();

$_SESSION = array();

header('Location: controllers/login.php');

die();