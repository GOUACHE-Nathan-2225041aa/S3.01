<?php

namespace app\models\games;

use PDO;
use PDOException;

class Localization
{
    public function __construct(private PDO $connection) {}

    public function getHint(string $gameId, string $language): ?string
    {
        try {
            $statement = $this->connection->prepare("SELECT text FROM localization WHERE game_id = :game_id AND language = :language AND field = 'hint'");
            $statement->execute(['game_id' => $gameId, 'language' => $language]);
            return $statement->fetchColumn();
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }
}
