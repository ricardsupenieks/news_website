<?php

namespace App\services\Register;

use Doctrine\DBAL\Connection;

class RegisterService {
    private Connection $connection;

    public function __construct() {
        $connectionParams = [
            'dbname' => 'news-api',
            'user' => 'root',
            'password' => $_ENV['MYSQL_PASSWORD'],
            'host' => $_ENV['MYSQL_HOST'],
            'driver' => 'pdo_mysql',
        ];

        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
    }

    public function checkEmail($email) {
        $emailDB = $this->connection->fetchAllKeyValue('SELECT id, email FROM `news-api`.users');
        if (in_array($email, $emailDB)) {
            return 'email taken';
        }
        return null;
    }

    public function execute(RegisterServiceRequest $request) {
        $this->connection->insert('users', [
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ]);
    }
}