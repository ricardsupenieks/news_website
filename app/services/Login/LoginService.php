<?php

namespace App\services\Login;

class LoginService
{
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

    public function execute(LoginServiceRequest $request) {
        $resultSet = $this->connection->executeQuery(
            'SELECT id FROM `news-api`.users WHERE email=? AND password=?', [
                $request->getEmail(),
                $request->getPassword()]);

        return $resultSet->fetchAssociative();
    }
}