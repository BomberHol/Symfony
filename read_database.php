<?php

function connectDatabase(): PDO
{
    // Создаёт объект PDO, представляющий подключение к MySQL.
    // Использует фиксированные параметры dsn, username, password.

    $dsn = 'mysql:host=localhost;dbname=php_course';
    $user = 'bomber-hol';
    $password = '1212';
    return new PDO($dsn, $user, $password);
}

function saveUserToDatabase(PDO $pdo, array $userParams): int
{
    // Добавляет пользователя в таблицу 'user' с помощью INSERT.
    // Возвращает целочисленный ID добавленного пользователя.
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
    return 1;
}

$database = connectDatabase();
$user = [
    'first_name' => 'Аrtem',
    'last_name' => 'Antonov',
    'middle_name' => 'Sergeevich',
    'gender' => 'male',
    'birth_date' => '2006-10-04',
    'email' => 'abc123@gmail.com',
    'phone' => '11111',
    'avatar_path' => 'asd/asd/asd'
];
saveUserToDatabase($database, $user);
echo 'It`s OK';

