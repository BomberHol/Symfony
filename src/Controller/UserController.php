<?php

namespace App\Controller;

use App\Model\ConnectionProvider;
use App\Model\UserTable;
use App\Model\User;
use App\Model\RequestHelper;

class UserController 
{
    private const PATH_SAVE_IMAGE = __DIR__ . '/../../uploads/';

    private UserTable $userTable;
     
    public function __construct()
    {   
        $connection = ConnectionProvider::connectDatabase();
        $this->userTable = new UserTable($connection);
    }

    public function handlerRequest(): void 
    {
        RequestHelper::post('/api/users/avatar') && $this->saveImage();  
        RequestHelper::post('/api/users/profile') && $this->addUser();   
        RequestHelper::get('user_id') ? $this->showUser($_GET['user_id']) : $this->index();  
    }
    
    private function saveImage(): void
    {
        $tmpPathFile = RequestHelper::getPathTmpFile('avatar'); 
        $newName = '';
        $newName = match (mime_content_type($tmpPathFile)) {
            'image/png' => (string)time() . '.png',
            'image/jpeg' => (string)time() . '.jpeg',
            'image/gif' => (string)time() . '.gif',
            default => throw new \RuntimeException('Invalid file format!')
        };
        $newPathFile = self::PATH_SAVE_IMAGE . $newName;
        if (!move_uploaded_file($tmpPathFile, $newPathFile)) {
            throw new \RuntimeException("Failed to move file from temporary directory.");
        }
        header('Content-Type: application/json');
        echo json_encode(['redirect' => $newName]);
        die();
    }

    private function showUser(int $user_id): void
    {
        $user = $this->userTable->findUserInDatabase($user_id);
        if ($user) {
            $this->print_user($user);
        }
    }

    private function addUser(): void
    {
        $user = $this->getNewUserFromForm();
        $userId = $this->userTable->saveUserToDatabase($user);

        $redirectUrl = "/index.php?user_id=$userId";
        header('Content-Type: application/json');
        echo json_encode(['redirect' => $redirectUrl]);
        die();       
    }

    private function getNewUserFromForm(): User
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $requiredKeys = ['first_name', 'last_name', 'middle_name', 'gender', 'birth_date', 'email', 'phone', 'avatar_path'];   //-conf
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key]) || $data[$key] === "") {
                http_response_code(400);
                throw new \RuntimeException("{$key} was not specified");
            }
        }
        return new User(null, $data['first_name'], $data['last_name'], $data['middle_name'], $data['gender'], $data['birth_date'], $data['email'], $data['phone'], $data['avatar_path']);   //-conf
    }

    private function print_user(User $user): void
    {
        require __DIR__ . '/../View/profile.php';
    }

    private function index(): void
    {
        require __DIR__ . '/../View/form.php';
    } 
}