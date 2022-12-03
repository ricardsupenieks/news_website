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

    public function store() {
        $registerService = new RegisterService();
        $emailCheck = $registerService->checkEmail($_POST['email']);
        if ($emailCheck !== null) {
            return new Template('register.twig', ['emailTaken' => $emailCheck]);
        }

        if ($_POST['password'] != $_POST['password_repeat']) {
            return new Template('register.twig', ['passwordsMatch' => false]);
        }

        $registerService->execute(
            new RegisterServiceRequest(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
            )
        );

        return new Redirect('/login');
    }
}