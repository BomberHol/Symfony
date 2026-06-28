<?php

require_once __DIR__ . '/../Model/connectionProvider.php';
require_once __DIR__ . '/../Model/userTable.php';

class UserController 
{
    private UserTable $userTable;

    public function __construct()
    {   
        $connection = ConnectionProvider::connectDatabase();
        $this->userTable = new UserTable($connection);
    }

    private function getNewUserFromForm(): User
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $requiredKeys = ['first_name', 'last_name', 'middle_name', 'gender', 'birth_date', 'email', 'phone', 'avatar_path'];
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key]) || $data[$key] === "") {
                http_response_code(400);
                throw new RuntimeException("{$key} was not specified");
            }
        }
        return new User(null, $data['first_name'], $data['last_name'], $data['middle_name'], $data['gender'], $data['birth_date'], $data['email'], $data['phone'], $data['avatar_path']);
    }

    private function print_user(User $user) 
    {
        require __DIR__ . '/../View/profile.php';
    }

    private function index(): void
    {
        require __DIR__ . '/../View/form.php';
    }

    private function addUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->getNewUserFromForm();
            $userId = $this->userTable->saveUserToDatabase($user);
            
            $redirectUrl = "/index.php?user_id=$userId";
            header('Content-Type: application/json');
            echo json_encode(['redirect' => $redirectUrl]);
            die();
        }
    }

    private function showUser(): void
    {
        if (isset($_GET['user_id'])) {
            $user = $this->userTable->findUserInDatabase($_GET['user_id']);
            if ($user) {
                $this->print_user($user);
            }
        } else {
            $this->index();
        }
    }

    public function handlerRequest(): void 
    {
        $method = $_SERVER['REQUEST_METHOD'];
        match ($method) {
            'GET' => $this->showUser(),
            'POST' => $this->addUser()
        };
    }
}