<?php

namespace Blogg\Domain;

class Post
{
    private $id;
    private $title;
    private $categorie_id;
    private $tag_id;
    private $name;
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

    public function getCategorieName(): string
    {
        return $this->name;
    }

    public function getTagId()
    {
        return $this->tag_id;
    }

    public function getTagName(): array
    {
        return $this->name;
    }
}
