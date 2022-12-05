<?php

require_once '../vendor/autoload.php';

use App\Controllers\ArticleController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\RegisterController;
use App\Models\User;
use App\Redirect;
use App\Template;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable("/home/ricards/PhpstormProjects/news-website");
$dotenv->load();

session_start();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [ArticleController::class, 'index']);

    $r->addRoute('GET', '/register', [RegisterController::class, 'showForm']);
    $r->addRoute('POST', '/register', [RegisterController::class, 'store']);

    $r->addRoute('GET', '/login', [LoginController::class, 'showForm']);
    $r->addRoute('POST', '/login', [LoginController::class, 'execute']);

    $r->addRoute('GET', '/logout', [LogoutController::class, 'logOut']);

});

$loader = new FilesystemLoader('../views');
$twig = new Environment($loader);

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars

        [$controller, $method] = $handler;
        $response = (new $controller)->{$method}($vars);

        $userID = $_SESSION['user'];
        $twig->addGlobal('userID', $userID);

        if ($userID !== null) {
            $user = new User($userID);

            $twig->addGlobal('user', $user->getName());
        }

        if ($response instanceof Template) {
            echo $twig->render($response->getPath(), $response->getParams());
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getUrl());
        }

        break;
}
