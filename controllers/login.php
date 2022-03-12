<?php

require_once '../user.php';
require_once '../crud.php';
require_once '../helpers/helper.php';
require_once '../config.php';

session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../index.php');
}

$errors = '';

$conn = getPDOConection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = filter_var(strtolower($_POST['user']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = hash('sha512',$password);

    $stmt = $conn->prepare('SELECT * FROM users WHERE user = :user AND pass = :pass');
    $stmt->execute(array(':user' => $user, ':pass' => $password));
    $result = $stmt->fetch();

    if ($result !== false) {
        $_SESSION['user'] = $user;
        header('Location: content.php');
    } else {
        $errors .='<li>Datos incorrectos</li>'; 
    }
}

require_once '../views/login.php';
