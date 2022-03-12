<?php

function url($string = null) // controllers/register.php
{   
    $url = "http://peskorea.test/" . $string;

    return $url; 
}

function location($route)
{
    header("Location: {$route}.php");
}

function show($message)
{
    return "<li style='color: #ef5350;'>{$message}</li>";
}