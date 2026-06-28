<?php

require_once 'src/Controller/userController.php';

try {
    $userController = new UserController();
    $userController->handlerRequest();

} catch (PDOException $error) {
    echo $error->getMessage();
} catch (RuntimeException $error) {
    echo $error->getMessage();
}

