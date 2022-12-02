<?php

namespace App\Controllers;

use App\Redirect;
use App\services\Register\RegisterService;
use App\services\Register\RegisterServiceRequest;
use App\Template;

class RegisterController
{

    public function showForm(): Template {
        return new Template('register.twig');
    }

    public function store(){
        $registerService = new RegisterService();

        $registerService->execute(
            new RegisterServiceRequest(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['password_repeat']
            )
        );

        return new Redirect('/login');
    }
}