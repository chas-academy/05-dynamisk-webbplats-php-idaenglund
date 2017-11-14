<?php

namespace Blogg\Controllers;

use Blogg\Exceptions\NotFoundException;

class DefaultController extends AbstractController
{
    public function start(): string
    {


        return $this->render('views/layout.php', []);
    }
}
