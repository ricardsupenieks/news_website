<?php

namespace App\Models;

class Article
{
    private string $url;
    private string $title;
    private ?string $author;
    private string $description;
    private ?string $imageUrl;


    public function __construct(string $url, string $title, ?string $author = null, string $description, ?string $imageUrl = null){

        $this->url = $url;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return substr($this->url, 0, -1);
    }
}