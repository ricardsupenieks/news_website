<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\Login\LoginService;
use App\Services\Login\LoginServiceRequest;
use App\Template;

class LoginController
{
    public function showForm(): Template
    {
        return new Template('login.twig');
    }

    public function execute(): Redirect
    {
        $loginService = new LoginService();
        $user = $loginService->execute(
            new LoginServiceRequest(
                $_POST['email'],
                $_POST['password'],
            )
        );
        if ($user === null) {
            $_SESSION['errors']['userCredentials'] = false;
        }

        if (! empty($_SESSION['errors'])) {
            return new Redirect('/login');
        }

        $_SESSION['user'] = $user['id'];
        return new Redirect('/');
    }
}

