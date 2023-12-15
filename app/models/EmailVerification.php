<?php

namespace app\models;

use PDO;
use PDOException;

class EmailVerification
{
    public function __construct(private PDO $connection) {}

    public function setEmail(string $email, string $url, string $expiration_date): void
    {
        $query = 'INSERT INTO email_check (email, url, expiration_date) VALUES (?, ?, ?)';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$email, $url, $expiration_date]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }
    }

    public function getEmailByURL($url): ?array
    {
        $query = 'SELECT * FROM email_check WHERE url = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$url]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }

        $email = $statement->fetch(PDO::FETCH_ASSOC);

        return $email ?: null;
    }

    public function getEmail($email): ?array
    {
        $query = 'SELECT * FROM email_check WHERE email = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$email]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }

        $email = $statement->fetch(PDO::FETCH_ASSOC);

        return $email ?: null;
    }

    public function deleteEmail($email): void
    {
        $query = 'DELETE FROM email_check WHERE email = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$email]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }
    }

    public function updateURL($email, $url, $expiration_date): void
    {
        $query = 'UPDATE email_check SET url = ?, expiration_date = ? WHERE email = ?';

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([$url, $expiration_date, $email]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }
    }
}
