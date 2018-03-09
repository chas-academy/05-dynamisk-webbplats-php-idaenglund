<?php

namespace Blogg\Domain;

class Post
{
    private $id;
    private $author;
    private $postdate;
    private $title;
    private $content;

    private $category;
    private $category_id;

    private $tags;
    private $tag_ids;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
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

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getTagIds(): string
    {
        return $this->tag_ids;
    }
}
