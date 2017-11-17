<?php

namespace Blogg\Domain;

class Post 
{
    private $id;
    private $title;
    private $categorie_id; 
    private $postdate;
    private $content;


    public function getId(): int
    {
        return $this->id;
    }

    public function getPostDate(): string 
    {
        return $this->postdate;
    }

    public function getTitle(): string  
    {
        return $this->title; 
    }

    public function getContent(): string 
    {
        return $this->content;
    }

    public function getCategorieId(): int
    {
        return $this->categorie_id; 
    }

    public function getTagId(): int
    {
        return $this->tag_id; 
    }

}