<?php

namespace App\Services\Login;

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
            'SELECT id FROM `news-api`.users WHERE email=?', [
            $request->getEmail()]);

        $id = $resultSet->fetchAssociative();

        $resultSet = $this->connection->executeQuery(
            'SELECT password FROM `news-api`.users WHERE id=?', [
            $id["id"]]);
        $hash = $resultSet->fetchAllAssociative();

        if (password_verify($request->getPassword(), $hash[0]["password"])) {
            return $id;
        }
        return false;
    }
}