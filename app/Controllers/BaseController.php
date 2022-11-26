<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use jcobhams\NewsApi\NewsApi;

class BaseController{
    private FilesystemLoader $loader;
    private Environment $twig;
    private NewsApi $apiClient;

    public function __construct() {
        $this->loader = new FilesystemLoader('views');
        $this->twig = new Environment($this->loader);
        $this->apiClient = new NewsApi($_ENV['NEWS_API_KEY']);
    }

    public function render(string $template, array $variables = []): string {
        return $this->twig->render($template, $variables);
    }

    public function newsApi(): NewsApi {
        return $this->apiClient;
    }

}