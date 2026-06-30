<?php

namespace App\Model;

class RequestHelper 
{
    public static function post(string $possibleUrl): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $possibleUrl === $_SERVER['REQUEST_URI'];
        }
        return false;
    }

    public static function get(string $parametr): bool 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return isset($_GET[$parametr]) || $parametr === $_SERVER['REQUEST_URI'];
        }
        return false;
    }

    public static function patch(string $possibleUrl): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
            return $possibleUrl === $_SERVER['REQUEST_URI'];
        }
        return false;
    }

    public static function delete(string $possibleUrl): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            return str_contains($_SERVER['REQUEST_URI'], $possibleUrl);
        }
        return false;
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