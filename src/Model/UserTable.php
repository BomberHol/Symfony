<?php

namespace App\Model;

use App\Model\User;

class UserTable 
{
    private \PDO $connection;

    public function __construct(\PDO $connection) 
    {
        $this->connection = $connection;
    }

    public function saveUserToDatabase(User $user): int
    {
        $query = "INSERT INTO `user` (`first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `email`, `phone`, `avatar_path`)
                  VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path);";
        $stmt = $this->connection->prepare($query);
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
        $userId = $this->connection->lastInsertId();
        if ($userId === false) {
            throw new \RuntimeException('Unable to get the id of the added user.');
        }
        return $userId;
    }

    public function findUserInDatabase(int $userId): ?User
    {
        $query = "SELECT `first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `email`, `phone`, `avatar_path`
                FROM `user` WHERE `user_id` = :user_id;";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            'user_id' => $userId
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new User($userId, $data['first_name'], $data['last_name'], $data['middle_name'], $data['gender'], $data['birth_date'], $data['email'], $data['phone'], $data['avatar_path']);
        } 
        return null;
       
    }
}