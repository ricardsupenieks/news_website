<?php

namespace App\Controllers;

class ArticleController{

    public function index(){
        include "views/main.php";

    }

    public function search(){
        include "views/search.php";
    }
}