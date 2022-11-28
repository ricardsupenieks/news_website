<?php

namespace App\Models;

class Article
{
    private string $url;
    private ?string $title;
    private ?string $imageUrl;


    public function __construct(string $url, ?string $title = null, ?string $imageUrl = null){

        $this->url = $url;
        $this->title = $title;
        $this->imageUrl = $imageUrl;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}