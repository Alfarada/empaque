<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Register</title>

</head>

<body>
    <div class="row">
        <div class="container-register valign-wrapper center-align">
            <div class="col s12 m8 offset-m2 l4 offset-l4">
                <h3 class="title">PESKOREA S.A</h3>
                <h4 class="grey-text">Registro</h4>
                <!-- Reenviando datos a la misma página -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" name="login">
                    <div class="input-field">
                        <i class="material-icons prefix">alternate_email</i>
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="user validate">
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">password</i>
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" minlength="6" maxlength="12" class="password validate">
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">check</i>
                        <label for="password_2">Confirmar contraseña</label>
                        <input type="password" id="password_2" name="password_2" minlength="6" maxlength="12" class="password_btn">
                    </div>
                    <button class="btn waves-effect waves-light blue submit" type="submit">Enviar</button>

                    <?php if (!empty($errors)) : ?>
                        <div class="errors">
                            <ul>
                                <?php echo $errors;  ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </form>
                <p class="register_text">
                    ¿ Ya tienes una cuenta ?
                    <a href="<?= url('controllers/login.php'); ?> ">Inicia sesión.</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>