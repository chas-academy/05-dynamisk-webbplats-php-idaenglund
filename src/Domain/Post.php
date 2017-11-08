<?php

namespace Blogg\Domain;

class Post 
{
    private $id;
    private $title;
    private $postdate;
    private $content;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPostDate(): datetime
    {
        return $this->datetime;
    }

    public function getTitle(): string  
    {
        return $this->title; 
    }

    public function getContent(): string 
    {
        return $this->content;
    }

}