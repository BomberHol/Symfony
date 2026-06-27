<?php

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

function getConnectionParams(): array
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $requiredKeys = ['first_name', 'last_name', 'middle_name', 'gender', 'birth_date', 'email', 'phone', 'avatar_path'];
    foreach ($requiredKeys as $key) {
        if (!isset($data[$key]) || $data[$key] === "") {
            throw new RuntimeException("{$key} was not specified");
        }
    }
    return $data;
}

function saveUserToDatabase(PDO $pdo, array $userParams): int
{
    $query = "INSERT INTO `user` (`first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `email`, `phone`, `avatar_path`)
              VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path);";
    $stmt = $pdo -> prepare($query);
    $stmt -> execute([
        'first_name' => $userParams['first_name'],
        'last_name' => $userParams['last_name'],
        'middle_name' => $userParams['middle_name'],
        'gender' => $userParams['gender'],
        'birth_date' => $userParams['birth_date'],
        'email' => $userParams['email'],
        'phone' => $userParams['phone'],
        'avatar_path' => $userParams['avatar_path']
    ]);
    $number = $pdo -> lastInsertId();
    if ($number === false) {
        throw new RuntimeException('Unable to get the id of the added user.');
    }
    return $number;
}



try {
    $database = connectDatabase();
    $user = getConnectionParams();
    echo saveUserToDatabase($database, $user);
} catch (PDOException $error) {
    echo $error->getMessage();
} catch (RuntimeException $error) {
    echo $error->getMessage();
}