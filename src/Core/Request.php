<?php
   namespace Blogg\Core;
   use Blogg\Core\FilteredMap; 


    class Request
    {
        const GET = 'GET';
        const POST = 'POST';
        private $domain;
        private $path;
        private $method;
        private $params;
        private $cookies;
        
        
        public function __construct(){
            $this->domain = $_SERVER['HTTP_HOST']; // tex 05-dynamisk-webbplats.com
            $this->path = $_SERVER['REQUEST_URI']; // tex posts
            $this->method = $_SERVER['REQUEST_METHOD']; // GET, POST
            $this->params = new FilteredMap(
                array_merge($_POST, $_GET)
            );
            $this->cookies = new FilteredMap($_COOKIE);
        }

        public function getUrl(): string
        {
            return $this->domain . $this->path;
        }
        public function getDomain(): string
        {
            return $this->domain;
        }
        public function getPath(): string
        {
            return $this->path;
        }
        public function getMethod(): string
        {
            return $this->method;
        }
        public function isPost(): bool
        {
            return $this->method === self::POST;
        }
        public function isGet(): bool
        {
            return $this->method === self::GET;
        }
        public function getParams(): FilteredMap
        {
            return $this->params;
        }
        public function getCookies(): FilteredMap
        {
            return $this->cookies;
        }
    }