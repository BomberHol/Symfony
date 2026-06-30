<?php

namespace App\Model;

class RequestHelper 
{
    public static function post(string $possibleUrl): bool
    {
        return $possibleUrl === $_SERVER['REQUEST_URI'];
    }

    public static function get(string $parametr): bool 
    {
        return isset($_GET[$parametr]);
    }

    public static function getPathTmpFile(string $nameFile): string
    {   
        if (isset($_FILES[$nameFile]['tmp_name'])) {
            return $_FILES[$nameFile]['tmp_name'];
        } else {
            throw new \RuntimeException("The file named $nameFile does not exist.");
        }
    } 
}