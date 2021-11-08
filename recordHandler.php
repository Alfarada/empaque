<?php

require_once 'helpers/helper.php';

class recordHandler extends CrudUser
{   
    protected string $errors = '';

    public function __construct(){}

    public function emptyField(User $user)
    {   
        if (empty($user->name()) or empty($user->password()) or empty($user->password2())) {
            $this->errors .= show('Porfavor rellene los campos correctamente.');          
        }

        return;
    }

    public function isExisting($result)
    {   
        if ($result != false) {
            $this->errors .= show('El nombre de usuario ya existe.');
        }

        return;
    }

    public function encryptPassword(User $user)
    {   
        $pass  = hash('sha512', $user->password());
        $pass_2 = hash('sha512', $user->password2());
        
        $user->setPassword($pass);
        $user->setPassword2($pass_2);
    }

    public function register(User $user)
    {
        if ($this->errors == '') {
            $db = DB::connect();
            $statement = $db->prepare('INSERT INTO users (id, user, pass) VALUES (null, :user, :pass)');
            $statement->execute(array(
                ':user' => $user->name(),
                ':pass' => $user->password()
            ));

            header('Location: login.php?message=Usuario registrado con exito.');
        }
    }

    public function passwordEquals($pass, $pass_2)    
    {
        if ($pass !== $pass_2) {
            return $this->errors .= show('Porfavor verifique que las contraseñas sean iguales.');
        }

        return $this->errors;
    }
}