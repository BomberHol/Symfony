<?php

class User 
{
    private ?int $userId;
    private string $firstName;
    private string $lastName;
    private string $middleName;
    private string $gender;
    private string $birth_date;
    private string $email;
    private string $phone;
    private string $avatar_path;

    public function __construct(?int $userId, string $firstName, string $lastName, string $middleName, string $gender, string $birth_date, string $email, string $phone, string $avatar_path) 
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->gender = $gender;
        $this->birth_date = $birth_date;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar_path = $avatar_path;
    }

   public function getUserId(): ?int
   {
        return $this->userId;
   }

   public function getFirstName(): string
   {
        return $this->firstName;
   }

   public function getLastName(): string
   {
        return $this->lastName;
   }

   public function getMiddleName(): string
   {
        return $this->middleName;
   }
   
   public function getGender(): string
   {
        return $this->gender;
   }

   public function getBirthDate(): string
   {
        return $this->birth_date;
   }

   public function getEmail(): string
   {
        return $this->email;
   }

   public function getPhone(): string
   {
        return $this->phone;
   }

   public function getAvatarPath(): string
   {
        return $this->avatar_path;
   }

}