<?php 

namespace Blogg\Domain;

class User 

{
    private $id;
    private $username;
    private $password;
}

public function __construct (
    int $id = null, 
    string $username,
    string $password
) {
    $this->id = $id; 
    $this->username = $username; 
    $this->password = $password; 

}

public function getId(): id 
{
    return $this->id; 

}

public function getUsername(): username
{
    return $this->username;
    
}

public function getPassword(): password
{
    return $this->password; 
    
}