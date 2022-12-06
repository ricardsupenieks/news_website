<?php

namespace App\Services\Register;

use App\Database;
use Doctrine\DBAL\Connection;

class RegisterService
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function checkIfEmailTaken($email): bool
    {
        $emailInDatabase = $this->connection->fetchAllKeyValue('SELECT id, email FROM `news-api`.users');
        if (in_array($email, $emailInDatabase)) {
            return true;
        }
        return false;
    }

    public function execute(RegisterServiceRequest $request): void
    {
        $this->connection->insert('users', [
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ]);
    }
}