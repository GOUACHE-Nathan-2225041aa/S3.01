<?php

namespace app\models;

use PDO;

class User
{
    public function __construct(private PDO $connection) {}

    public function getUserByUsername(string $username): ?array
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

    public function createUser(array $data): void
    {
        $query = 'INSERT INTO account (admin, email, ip, password, username) VALUES (0, ?, ?, ?, ?)';
        $statement = $this->connection->prepare($query);

        if (!$statement) {
            error_log('Failed to prepare statement');
            return;
        }

        if (!$statement->execute([
            $data['email'],
            $data['ip'],
            $data['password'],
            $data['username']
        ])) {
            error_log('Failed to execute statement');
        }
    }

    public function isUserEmailExist(string $email): bool
    {
        // TODO - Implement isUserEmailExist() method
        return false;
    }

    public function isUsernameExist(string $username): bool
    {
        // TODO - Implement isUsernameExist() method
        return false;
    }
}
