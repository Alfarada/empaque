<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="row">
        <div class="container-login valign-wrapper center-align">
            <!-- <div class="col s12 m8 offset-m2 l6 offset-l3 xl5 offset-xl3"> -->
            <div class="col s12 m8 offset-m2 l4 offset-l4">
                <i class='bx bxl-dropbox bx-lg' ></i>
                <h3 class="title">Empaque</h3>
                <h4 class="grey-text">Inicio de Sesión</h4>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" name="login">
                    <div class="input-field">
                        <i class="material-icons prefix">alternate_email</i>
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="user" aria-describedby="emailHelp">
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">password</i>
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" minlength="6" maxlength="12" class="password_btn">
                    </div>
                    <button class="btn waves-effect waves-light blue submit" type="submit">Iniciar Sesión</button>

                    <!-- if the user has registered, then it shows a message -->
                    <p style="color: #66bb6a; margin-bottom:25px;">
                        <b>
                            <?php echo !empty($_GET['message']) ? $_GET['message'] : ''; ?>
                        </b>
                    </p>

                    <!-- if there is an error then it shows message -->
                    <?php if (!empty($errors)) : ?>
                        <div class="errors">
                            <ul>
                                <li>
                                    <p>
                                        <?php echo $errors;  ?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>

                </form>
                <p class="register_text">
                    ¿ No tienes una cuenta?
                    <a href="<?php echo url('controllers/register.php'); ?>">Registrate.</a>
                </p>
            </div>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>