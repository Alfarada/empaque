<?php

class DB 
{
    private static $conn = null;
    private function __construct() {}

    public static function connect()
    {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$conn = new PDO('mysql:host=localhost;dbname=empaque','root','',$pdo_options);
        return self::$conn;
    }
}