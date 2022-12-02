<?php

namespace App\services\Article;

use App\Models\Article;
use App\Models\Collections\ArticlesCollection;
use jcobhams\NewsApi\NewsApi;

class FetchTopHeadlinesService {

    public function execute(): ArticlesCollection {
        $apiClient = new NewsApi($_ENV['NEWS_API_KEY']);

        $articlesApiResponse = $apiClient->getTopHeadLines(null, null, 'lv');

        $articles = new ArticlesCollection();
        foreach ($articlesApiResponse->articles as $article) {
            $articles->add(new Article($article->url, $article->title, $article->urlToImage));
        }

        return $articles;
    }
}