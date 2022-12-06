<?php

namespace App\ViewVariables;

use App\Database;

class ViewUserVariables
{
    public function getName(): string {
        return 'user';
    }

    public function getValue(): array {

        if (! isset($_SESSION['user'])) { // saprotu to ka itka nevajadzetu user jo tad var but tikai viens user, bet sajai majaslapai der
            return [];
        }

        $queryBuilder = Database::getConnection()->createQueryBuilder();

        $user = $queryBuilder
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $_SESSION['user'])
            ->fetchAssociative();

        return [
            "id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
        ];
    }
}