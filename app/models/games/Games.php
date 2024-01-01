<?php

namespace app\models\games;

use PDO;
use PDOException;

class Games
{
    public function __construct(private PDO $connection) {}

    public function getGameBySlug(string $slug): ?array
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM games WHERE slug = :slug");
            $statement->execute(['slug' => $slug]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }

    public function getFirstGameSlugByType(string $gameType): ?string
    {
        try {
            $statement = $this->connection->prepare("SELECT slug FROM games WHERE game_type = :game_type ORDER BY creation_date ASC LIMIT 1");
            $statement->execute(['game_type' => $gameType]);
            return $statement->fetchColumn();
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }
}
