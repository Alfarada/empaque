<?php

// class DB 
// {
//     private static $conn = null;
//     private function __construct() {}

//     public static function connect()
//     {
//         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
//         self::$conn = new PDO('mysql:host=localhost;dbname=empaque','root','',$pdo_options);
//         return self::$conn;
//     }
// }

function getPDOConection()
{
    try {
        $con = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
        return $con;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}