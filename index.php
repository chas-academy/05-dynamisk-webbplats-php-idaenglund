<?php
    use Blogg\Core\Router;
    use Blogg\Core\Request; 

    function autoloader($classname)
    {
        $lastSlash = strpos($classname, '\\') + 1;
        $classname = substr($classname, $lastSlash);
        $directory = str_replace('\\', '/', $classname);
        $filename = __DIR__ . '/src/' . $directory . '.php';
        require_once($filename);
    }

    spl_autoload_register('autoloader');

    /*$config = Config::getInstance()->get('db');
    $db = new PDO(
        'mysql:host=127.0.0.1;dbname=dynamisk_webbplats',
        $config['user'], 
        $config['password']
    );

    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $query = <<<SQL
        INSERT INTO posts(title,content)
        VALUES (:title, :content)
    SQL; 

    $statement = $db->prepare($query); 

    $params = [
        'title' => 'My first post', 
        'content' => 'This is my first text on my blog'
    ];

    $statement ->execute($params); 
    echo $db->lastInsertId(); 
*/

    $router = new Router();

   /*echo "<pre>";
        print_r($router);
    echo "</pre>";*/

    $response = $router->route(new Request());

    echo $response;
    
