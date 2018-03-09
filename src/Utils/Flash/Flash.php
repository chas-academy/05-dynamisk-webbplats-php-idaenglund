<?php

namespace Blogg\Utils\Flash;

use Blogg\Utils\Flash\Views\Message;

class Flash
{
    public function message($message, $classes = [])
    {
        $flash = [
          'message' => $message,
          'classes' => $classes
      ];

        $_SESSION['flash'] = $flash;
    }

    public function flash()
    {
        if ($this->check()) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $this->create($flash);
        } else {
            return false;
        }
    }

    public function check()
    {
        if (array_key_exists('flash', $_SESSION) && !empty($_SESSION['flash'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessage()
    {
        if ($this->check()) {
            return $_SESSION['flash'];
        } else {
            return false;
        }
    }

    private function getClasses($flash)
    {
        $classes = '';
        if (count($flash['classes'])) {
            foreach ($flash['classes'] as $value) {
                $classes .= "$value ";
            }
        }
        trim($classes);
        return $classes;
    }
    private function create($flash)
    {
        $classes = $this->getClasses($flash);
        $message = new Message($flash, $classes);
        return $message->getMessage();
    }
}
