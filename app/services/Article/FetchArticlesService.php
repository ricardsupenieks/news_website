<?php

namespace App\services\Article;

use App\Models\Article;
use App\Models\Collections\ArticlesCollection;
use jcobhams\NewsApi\NewsApi;

class FetchArticlesService {

    public function execute(string $searchTerm): ArticlesCollection {
        $apiClient = new NewsApi($_ENV['NEWS_API_KEY']);

        $articlesApiResponse = $apiClient->getEverything($searchTerm);


        $articles = new ArticlesCollection();

        foreach ($articlesApiResponse->articles as $article) {
            $articles->add(new Article($article->url, $article->title, $article->urlToImage));
        }

        return $articles;
    }

}