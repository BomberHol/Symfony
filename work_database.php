<?php

require_once 'user.php';

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

function saveUserToDatabase(PDO $pdo, User $user): int
{
    $query = "INSERT INTO `user` (`first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `email`, `phone`, `avatar_path`)
              VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path);";
    $stmt = $pdo -> prepare($query);
    $stmt -> execute([
        'first_name' => $user->getFirstName(),
        'last_name' => $user->getLastName(),
        'middle_name' => $user->getMiddleName(),
        'gender' => $user->getGender(),
        'birth_date' => $user->getBirthDate(),
        'email' => $user->getEmail(),
        'phone' => $user->getPhone(),
        'avatar_path' => $user->getAvatarPath()
    ]);
    $userId = $pdo->lastInsertId();
    if ($userId === false) {
        throw new RuntimeException('Unable to get the id of the added user.');
    }
    return $userId;
}

function findUserInDatabase(PDO $pdo, int $userId): ?User
{
    $query = "SELECT `first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `email`, `phone`, `avatar_path`
              FROM `user` WHERE `user_id` = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $userId
    ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        return new User($userId, $data['first_name'], $data['last_name'], $data['middle_name'], $data['gender'], $data['birth_date'], $data['email'], $data['phone'], $data['avatar_path']);
    } else {
        return null;
    }
}

function print_arr(User $user) {
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
    $database = connectDatabase();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = getNewUserFromForm();
        $userId = saveUserToDatabase($database, $user);

        $redirectUrl = "/work_database.php?user_id=$userId";
        header('Content-Type: application/json');
        echo json_encode(['redirect' => $redirectUrl]);
        die();
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $user = findUserInDatabase($database, $_GET['user_id']);
        if ($user) {
            print_arr($user);
        }
    }
} catch (PDOException $error) {
    echo $error->getMessage();
} catch (RuntimeException $error) {
    echo $error->getMessage();
}