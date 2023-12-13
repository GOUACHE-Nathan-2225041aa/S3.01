<?php

namespace app\models;

use PDO;

class User
{
    public function __construct(private PDO $connection) {}

    public function getUser(string $username): ?array
    {
        $query = 'SELECT * FROM account WHERE username = ?';
        $statement = $this->connection->prepare($query);

        if (!$statement) {
            error_log('Failed to prepare statement');
            return null;
        }

        if (!$statement->execute([$username])) {
            error_log('Failed to execute statement');
            return null;
        }

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
