<?php

require_once __DIR__ . '/vendor/autoload.php';
use App\Controller\UserController;

try {
    $userController = new UserController();
    $userController->handlerRequest();

} catch (PDOException $error) {
    echo $error->getMessage();
} catch (RuntimeException $error) {
    echo $error->getMessage();
}

