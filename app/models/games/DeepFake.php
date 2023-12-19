<?php

namespace app\models\games;

use PDO;
use PDOException;

class DeepFake
{
    public function __construct(private PDO $connection) {}

    public function createGame(array $data): void
    {
        $query = ''; // TODO - create query

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([]); // TODO - add data
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }
    }
}
