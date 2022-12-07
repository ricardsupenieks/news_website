<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\Register\RegisterService;
use App\Services\Register\RegisterServiceRequest;
use App\Template;

class RegisterController
{
    public function showForm(): Template
    {
        return new Template('register.twig');
    }

    public function store(): Redirect
    {

        $registerService = new RegisterService();

        $emailTakenCheck = $registerService->checkIfEmailTaken($_POST['email']);
        if ($emailTakenCheck === true) {
            $_SESSION['errors']['emailTaken'] = true;
        }

        if ($_POST['password'] != $_POST['password_repeat']) {
            $_SESSION['errors']['passwordsMatch'] = false;
        }

        if (! empty($_SESSION['errors'])) {
            return new Redirect('/register');
        }

        $registerService->execute(
            new RegisterServiceRequest(
                $_POST['name'],
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_DEFAULT),
            )
        );

        return new Redirect('/login');
    }
}