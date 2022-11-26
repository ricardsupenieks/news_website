<?php

namespace App\Controllers;

use App\Models\Article;

class ArticleController extends BaseController {

    public function index(): string {

        $searchTerm = $_GET['search'];

        if ($searchTerm === null) {
            return $this->render('main.html.twig');
        }

        $articlesApiResponse = $this->newsApi()->getEverything($searchTerm);

        $articles = [];
        foreach ($articlesApiResponse->articles as $article) {
            $articles[] = new Article($article->url, $article->title, $article->author, $article->description);
        }

       return $this->render('search.html.twig', ['searchTerm' => $searchTerm, 'articles' => $articles]);
    }

}