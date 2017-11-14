<?php 

namespace Blogg\Domain;

class User
{
    private $id;
    private $username;
    private $password;

    public function getId(): int
    {
        return $this->id; 
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password; 
    }
}