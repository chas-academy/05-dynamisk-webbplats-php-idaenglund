<?php

namespace Blogg\Utils\Flash\Views;

class Message
{
    public function __construct($flash = array(), $classes = '')
    {
        $this->flash = $flash;
        $this->classes = $classes;
    }

    public function getMessage()
    {
        return "
<div class=\"flash alert {$this->classes}\">" . PHP_EOL .
"\t{$this->flash['message']}" . PHP_EOL .
"</div>" . PHP_EOL;
    }
}
