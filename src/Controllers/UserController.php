<?php

namespace Blogg\Controllers;

use Blogg\Exceptions\DbException;
use Blogg\Exceptions\NotFoundException;
use Blogg\Models\PostModel;

use PDO;

class UserController extends AbstractController
{

    public function login(): string
    {   

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            $dbHandler = new PDO('mysql:host=localhost;dbname=blogg', 'root', 'root');
        
            $statement = $dbHandler->prepare(
                'SELECT * FROM users 
                WHERE username = :username 
                AND password = :password'
            );
            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->bindValue(':password', $password, PDO::PARAM_STR);
        
            $statement->execute();
            $result = $statement->fetchAll();

            if (!empty($result)) {
                $properties = [
                    'username' => $result[0]['username']
                ];

                setcookie('username', $properties['username']);

                return $this->render('views/writepost.php', $properties);
            }
        }

        return $this->render('views/layout.php', []);
        
        
    }

    public function logout()
    {
        $userName = $_COOKIE['username'];

        setcookie('username', $userName, 1);

        return header('Location: /');
    }

}