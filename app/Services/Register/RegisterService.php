<?php

namespace App\Services\Register;

use App\Database;
use Doctrine\DBAL\Connection;

class RegisterService {
    private Connection $connection;

    public function __construct() {
        $db = new Database();
        $this->connection = $db->connect();
    }

    public function checkIfEmailTaken($email): bool {
        $emailInDB = $this->connection->fetchAllKeyValue('SELECT id, email FROM `news-api`.users');
        if (in_array($email, $emailInDB)) {
            return true;
        }
        return false;
    }

    public function execute(RegisterServiceRequest $request): void {
        $this->connection->insert('users', [
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ]);
    }
}