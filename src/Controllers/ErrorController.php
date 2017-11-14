<?php

namespace Blogg\Controllers;

class ErrorController extends AbstractController
{
    public function notFound(): string
    {
        $properties = ['errorMessage' => 'Page not found!'];
        return $this->render('views/error.php', $properties);
    }

    public function requiresLogin(): string
    {
        $properties = ['errorMessage' => 'You must be logged in to do that!'];
        return $this->render('views/error.php', $properties);
    }
}
