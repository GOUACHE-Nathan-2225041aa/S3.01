<?php

namespace app\models;

use PDO;
use PDOException;

class User
{
    public function __construct(private PDO $connection) {}

    public function getUserByUsername(string $username): ?array
    {
        $query = 'SELECT * FROM account WHERE username = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$username]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function finalizeUserAccountCreation(array $data): void
    {
        $query = 'UPDATE account SET ip = ?, password = ?, username = ? WHERE email = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([
                $data['ip'],
                $data['password'],
                $data['username'],
                $data['email']
            ]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }
    }

    public function createUnverifiedUser(array $data): void
    {
        $query = 'INSERT INTO account (admin, email, ip, id) VALUES (0, ?, ?, ?)';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([
                $data['email'],
                $data['ip'],
                $data['uuid']
            ]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }
    }

    public function isUserEmailExist(string $email): bool
    {
        $query = 'SELECT COUNT(*) FROM account WHERE email = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$email]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return true;
        }

        $count = $statement->fetchColumn();

        return $count > 0;
    }

    public function isUsernameExist(string $username): bool
    {
        $query = 'SELECT COUNT(*) FROM account WHERE username = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$username]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return true;
        }

        $count = $statement->fetchColumn();

        return $count > 0;
    }
}
