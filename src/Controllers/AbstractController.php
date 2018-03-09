<?php

namespace Blogg\Controllers;

use Blogg\Core\Request;
use Blogg\Utils\Flash\Flash;

abstract class AbstractController
{
    protected $request;
    protected $view;
    protected $userId;
    protected $flash;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->flash = new Flash();
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
            $this->flash->message($params['errorMessage'], ['alert-danger']);
        }

        header('Location: ' . $url);
    }
}
