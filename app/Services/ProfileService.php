<?php

namespace App\Services;

use App\Database;

class ProfileService
{
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function getAllUserData(): UserData
    {
        $user = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $_SESSION['user'])
            ->fetchAssociative();

        return new UserData($user['name'], $user['email'], $user['password']);
    }

    public function updateUserData(string $updatedUserName, string $updatedUserEmail, string $updatedUserPassword): void
    {
        $this->connection->update('`news-api`.users', ['name' => $updatedUserName], ['id' => $_SESSION['user']]);

        $this->connection->update('`news-api`.users', ['email' => $updatedUserEmail], ['id' => $_SESSION['user']]);

        $password = password_hash($updatedUserPassword, PASSWORD_DEFAULT);
        $this->connection->update('`news-api`.users', ['password' => $password], ['id' => $_SESSION['user']]);
    }
}