<?php

include('./templates/header.html');

    // $username = $_POST['username'];
    // $password = $_POST['password'];

    // $dbHandler = new PDO('mysql:host=localhost;dbname=blogg', 'root', 'root');

    // $statement = $dbHandler->prepare(
    //     'SELECT * FROM users 
    //     WHERE username = :username 
    //     AND password = :password'
    // );
    // $statement->bindValue(':username', $username, PDO::PARAM_STR);
    // $statement->bindValue(':password', $password, PDO::PARAM_STR);

    // $statement->execute();
    // $result = $statement->fetchAll();

    // if (isset($result)) {
    //     print_r($result[0]['username']);
    // }
    
    echo '<h1>' . $username . '</h1>';

include('./templates/footer.html');

?>
