<?php

require_once 'config.php';

function getPDOConection()
{
    try {
        $con = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
        return $con;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getMysqliConection()
{   
    // $conn = new mysqli('localhost', 'root', '', 'empaque');
    return new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // echo 'hola mundo';
}