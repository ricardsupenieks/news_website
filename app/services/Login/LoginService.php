<?php

namespace App\services\Login;

use App\Database;
use Doctrine\DBAL\Connection;

class LoginService {
    private Connection $connection;

    public function __construct() {
        $db = new Database();
        $this->connection = $db->connect();
    }

    public function execute(LoginServiceRequest $request) {
        $resultSet = $this->connection->executeQuery(
            'SELECT id FROM `news-api`.users WHERE email=? AND password=?', [
                $request->getEmail(),
                $request->getPassword()]);

        return $resultSet->fetchAssociative();
    }
}