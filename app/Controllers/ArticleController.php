<?php

namespace App\Controllers;

use App\services\Article\FetchArticlesService;
use App\services\Article\FetchTopHeadlinesService;
use App\Template;

class ArticleController  {

    public function index(): Template {

        $searchTerm = $_GET['search'];

        if ($searchTerm === null) {
            $topHeadlines = (new FetchTopHeadlinesService())->execute();
            return new Template('main.twig', ['articles' => $topHeadlines->get(), 'user' => $_SESSION['user']]);
        }

        $articles = (new FetchArticlesService())->execute($searchTerm);

        return new Template('search.twig', ['searchTerm' => $searchTerm, 'articles' => $articles->get()]);
    }

}