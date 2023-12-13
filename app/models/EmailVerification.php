<?php

namespace app\models;

use PDO;

class EmailVerification
{
    public function __construct(private PDO $connection) {}

    public function setEmail(string $email, string $url, string $expiration_date): void
    {
        // TODO - implement setEmail() query
        $query = '';
        $statement = $this->connection->prepare($query);

        if (!$statement) {
            error_log('Failed to prepare statement');
            return;
        }

        if (!$statement->execute([$email, $url, $expiration_date])) {
            error_log('Failed to execute statement');
        }
    }

    public function getEmailByURL($url): ?array
    {
        // TODO - implement getEmailByURL() query
        $query = '';
        $statement = $this->connection->prepare($query);

        if (!$statement) {
            error_log('Failed to prepare statement');
            return null;
        }

        if (!$statement->execute([$url])) {
            error_log('Failed to execute statement');
            return null;
        }

        $email = $statement->fetch(PDO::FETCH_ASSOC);

        return $email ?: null;
    }

    public function getEmail($email): ?array
    {
        // TODO - implement getEmail() query
        $query = '';
        $statement = $this->connection->prepare($query);

        if (!$statement) {
            error_log('Failed to prepare statement');
            return null;
        }

        if (!$statement->execute([$email])) {
            error_log('Failed to execute statement');
            return null;
        }

        $email = $statement->fetch(PDO::FETCH_ASSOC);

        return $email ?: null;
    }

    public function deleteEmail($email): void
    {
        // TODO - implement deleteEmail() query
        $query = '';
        $statement = $this->connection->prepare($query);

        if (!$statement) {
            error_log('Failed to prepare statement');
            return;
        }

        if (!$statement->execute([$email])) {
            error_log('Failed to execute statement');
        }
    }
}
