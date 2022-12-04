<?php

namespace App\Controllers;

use App\Services\Article\FetchArticlesService;
use App\Services\Article\FetchTopHeadlinesService;
use App\Template;

class ArticleController  {

    public function index(): Template {

        $searchTerm = $_GET['search'];

        if ($searchTerm === null) {
            $topHeadlines = (new FetchTopHeadlinesService())->execute();
            return new Template('main.twig', ['articles' => $topHeadlines->get()]);
        }

        $articles = (new FetchArticlesService())->execute($searchTerm);

        return new Template('search.twig', ['searchTerm' => $searchTerm, 'articles' => $articles->get()]);
    }

}