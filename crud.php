<?php

require_once('db.php');
require_once('user.php');

class CrudUser
{
    public function __construct() {}

    // Consulta
    public function query($user)
    {
        $db = DB::connect();
        $statement = $db->prepare('SELECT * FROM users WHERE user = :user LIMIT 1');
        $statement->execute(array(':user' => $user->name()));
        return $statement->fetch();
    }
}