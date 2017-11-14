<?php
    namespace Blogg\Models;
    use PDO;

    class UserModel extends AbstractModel
    {
        const CLASSNAME = '\Blogg\Domain\User';

        public function login(string $username, string $password)
        {
            $statement = $this->db->prepare(
                'SELECT * FROM users 
                WHERE username = :username 
                AND password = :password'
            );

            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->bindValue(':password', $password, PDO::PARAM_STR);
        
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME)[0]; // not so pretty
        }

        public function readUser(int $userId)
        {
            $statement = $this->db->prepare(
                'SELECT * FROM users 
                WHERE id = :user_id'
            );

            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME)[0];
        }
    }