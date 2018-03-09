<?php

namespace Blogg\Controllers;

use Blogg\Exceptions\DbException;
use Blogg\Exceptions\NotFoundException;
use Blogg\Models\PostModel;
use Blogg\Models\UserModel;

class UserController extends AbstractController
{

    public function login(): string
    {
        if ($this->request->isPost()) {
            $username = $this->request->getParams()->get('username');
            $password = $this->request->getParams()->get('password');

            $userModel = new UserModel();
            $user = $userModel->login($username, $password);

            if (!empty($user)) {
                setcookie('user', $user->getId());

                return $this->redirect('/admin');
            }
        }

        return $this->redirect('/');
    }

    public function logout()
    {
        setcookie('user', '', time()-5000);

        return $this->redirect('/');
    }

    public function signin()
    {
        $errorMessage = $this->request->getParams()->get('errorMessage');

        $properties = [
            'errorMessage' => $errorMessage
        ];

        return $this->render('views/signin.php', $properties);
    }

}
