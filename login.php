<?php

    $username = $_POST['username'];
    $password = $_POST['password'];

    $dbHandler = new PDO('mysql:host=localhost;dbname=dynamisk_webbplats', 'root', 'root');

    $statement = $dbHandler->prepare(
        'SELECT * FROM users 
        WHERE username = :username 
        AND password = :password'
    );
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->bindValue(':password', $password, PDO::PARAM_STR);

    $statement->execute();
    $result = $statement->fetchAll();

    if (isset($result)) {
        print_r($result[0]['username']);
    }
?>
