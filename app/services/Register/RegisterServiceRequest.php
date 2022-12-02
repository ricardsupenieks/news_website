<?php

namespace App\services\Register;

class RegisterServiceRequest
{
    private string $name;
    private string $email;
    private string $password;
    private string $passwordRepeat;

    public function __construct(string $name, string $email, string $password, string $passwordRepeat) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }
}