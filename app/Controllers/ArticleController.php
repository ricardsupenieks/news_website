<?php

namespace App\Controllers;

use App\services\FetchArticlesService;
use App\Template;

class ArticleController  {

    public function index(): Template {

        $searchTerm = $_GET['search'];

        if ($searchTerm === null) {
            return new Template('main.html.twig');
        }

        $articles = (new FetchArticlesService())->execute($searchTerm);

        return new Template('search.html.twig', ['searchTerm' => $searchTerm, 'articles' => $articles->get()]);
    }

}