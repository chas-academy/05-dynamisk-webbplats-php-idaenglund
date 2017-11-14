<?php

namespace Blogg\Controllers;

use Blogg\Core\Request;

abstract class AbstractController
{
    protected $request;
    protected $view;
    protected $userId;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    protected function render(string $template, array $params): string
    {
        extract($params);

        ob_start();
        include_once('templates/header.php');
            include $template;
        include_once('templates/footer.php');
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    protected function redirect(string $url, array $params = null)
    {
        if (isset($params)) {
            $queryParams = http_build_query($params);
            $url = $url . '?' -$queryParams; 
        }

        header('Location: ' . $url); 
    }
}
