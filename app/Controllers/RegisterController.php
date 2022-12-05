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

    public function store()
    {
        $registerService = new RegisterService();
        $emailTakenCheck = $registerService->checkIfEmailTaken($_POST['email']);
        if ($emailTakenCheck !== false) {
            return new Template('register.twig', ['emailTaken' => $emailTakenCheck]);
        }

        if ($_POST['password'] != $_POST['password_repeat']) {
            return new Template('register.twig', ['passwordsMatch' => false]);
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