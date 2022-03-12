<?php

require_once '../user.php';
require_once '../crud.php';
// require_once '../recordHandler.php';
require_once '../helpers/helper.php';
require_once '../config.php';

session_start();

if (isset($_SESSION['user'])) {
    // redirige...
    header('Location: ../index.php');
}

// Comprobando que se reciben los datos 
// de la misma página con el metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = filter_var(strtolower($_POST['user']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password2 = $_POST['password_2'];

    $errors = '';
    $conn = getPDOConection();

    if (empty($user) or empty($password) or empty($password2) ) {
        $errors .= '<li>Porfavor rellena los campos correctamente</li>';
    } else {

        $stmt = $conn->prepare('SELECT * FROM users WHERE user = :user LIMIT 1');
        $stmt->execute(array(':user' => $user));
        $result = $stmt->fetch();

        if ($result != false) {
            $errors .= '<li>El nombre de usuario ya existe.</li>';
        }

        $password = hash('sha512', $password);
        $password2 = hash('sha512', $password2);

        if ($password !== $password2) {
            $errors .= '<li>Las contraseñas deben ser iguales.</li>';
        }
    }

    if ($errors == '') {
        $stmt = $conn->prepare('INSERT INTO users (id, user, pass) VALUES (null, :user, :pass)');
        $stmt->execute(array(':user' => $user, ':pass' => $password));
        header('Location: login.php?message=Usuario registrado con exito.');
    }

    $conn = null;

}

require_once '../views/register.php';