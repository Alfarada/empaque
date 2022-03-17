<?php

require_once '../user.php';
require_once '../crud.php';
// require_once '../recordHandler.php';
require_once '../helpers/helper.php';
require_once '../config.php';

session_start();

if (isset($_SESSION['email'])) {
    // redirige...
    header('Location: ../index.php');
}

// Comprobando que se reciben los datos 
// de la misma página con el metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password2 = $_POST['password_2'];

    $errors = '';
    $conn = getPDOConection();

    if (empty($email) or empty($password) or empty($password2)) {
        $errors .= '<li>Porfavor rellena los campos correctamente.</li>';
    } else {

        $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetch();

        // result = false  | no existe.
        // result != false | existe.

        if ($result != false) {
            $errors .= '<li>El nombre de usuario ya existe.</li>';
        }

        $password  = hash('sha512', $password);
        $password2 = hash('sha512', $password2);

        if ($password !== $password2) {
            $errors .= '<li>Las contraseñas deben ser iguales.</li>';
        }
    }

    $role = '';
    $admin = 'bob@example.com';

    if ($errors == '') {

        $sql = 'INSERT INTO users (id, email, pass, user_role) VALUES (null, :email, :pass, :user_role)';

        if ($email == $admin) {
            $role = 'admin';
        } else {
            $role = 'user';
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute(
            array(
                ':email' => $email,
                ':pass' => $password,
                ':user_role' => $role
            )
        );

        $con  = null;
        $stmt = null;

        header('Location: login.php?message=Usuario registrado con exito.');
    }

    $conn = null;
}

require_once '../views/register.php';
