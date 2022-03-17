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
    $email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = hash('sha512',$password);

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email AND pass = :pass');
    $stmt->execute(array(':email' => $email, ':pass' => $password));
    $result = $stmt->fetch();

    if ($result !== false) {
        $_SESSION['email'] = $email;
        header('Location: content.php');
    } else {
        $errors .='Datos incorrectos'; 
    }

    $conn = null;
}

require_once '../views/login.php';
