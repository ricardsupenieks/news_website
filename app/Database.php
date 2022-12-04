<?php

namespace App;

class Database {
    public function connect(){
        $connectionParams = [
            'dbname' => 'news-api',
            'user' => 'root',
            'password' => $_ENV['MYSQL_PASSWORD'],
            'host' => $_ENV['MYSQL_HOST'],
            'driver' => 'pdo_mysql',
        ];

        return \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
    }
}