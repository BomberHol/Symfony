<?php

require_once 'user.php';
require_once 'user_table.php';

CONST PATH_CONF = './config.ini';

function connectConfig(): array {
    if (!file_exists(PATH_CONF)) {
        throw new RuntimeException('The ' . PATH_CONF . ' does not exist');
    }

    $config = parse_ini_file(PATH_CONF);

    $requiredKeysConf = ['host', 'dbname', 'user', 'password'];
    foreach ($requiredKeysConf as $key) {
        if (!isset($config[$key])) {
            throw new RuntimeException("The $key field is missing in the config.");
        }
    }
    return $config;
}

function connectDatabase(): PDO
{
    $config = connectConfig();
    $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';';
    $user = $config['user'];
    $password = $config['password'];
    $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    return new PDO($dsn, $user, $password, $option);
}

function getNewUserFromForm(): User
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $requiredKeys = ['first_name', 'last_name', 'middle_name', 'gender', 'birth_date', 'email', 'phone', 'avatar_path'];
    foreach ($requiredKeys as $key) {
        if (!isset($data[$key]) || $data[$key] === "") {
            throw new RuntimeException("{$key} was not specified");
        }
    }
    return new User(null, $data['first_name'], $data['last_name'], $data['middle_name'], $data['gender'], $data['birth_date'], $data['email'], $data['phone'], $data['avatar_path']);
}

function print_user(User $user) {
    echo 'first_name = ' . htmlspecialchars($user->getFirstName()) . '<br>';
    echo 'last_name = ' . htmlspecialchars($user->getLastName()) . '<br>';
    echo 'middle_name = ' . htmlspecialchars($user->getMiddleName()) . '<br>';
    echo 'gender = ' . htmlspecialchars($user->getGender()) . '<br>';
    echo 'birth_date = ' . htmlspecialchars($user->getBirthDate()) . '<br>';
    echo 'email = ' . htmlspecialchars($user->getEmail()) . '<br>';
    echo 'phone = ' . htmlspecialchars($user->getPhone()) . '<br>';
    echo 'avatar_path = ' . htmlspecialchars($user->getAvatarPath()) . '<br>';
}


try {
    $userTable = new UserTable(connectDatabase());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = getNewUserFromForm();
        $userId = $userTable->saveUserToDatabase($user);
        
        $redirectUrl = "/work_database.php?user_id=$userId";
        header('Content-Type: application/json');
        echo json_encode(['redirect' => $redirectUrl]);
        die();
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['user_id'])) {
            throw new RuntimeException('The user ID was not passed.');
        }
        $user = $userTable->findUserInDatabase($_GET['user_id']);
        if ($user) {
            print_user($user);
        }
    }
} catch (PDOException $error) {
    echo $error->getMessage();
} catch (RuntimeException $error) {
    echo $error->getMessage();
}