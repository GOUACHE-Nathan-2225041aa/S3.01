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
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result === false ? null : $result;
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

    public function getNextGameSlug(string $currentGameSlug, string $gameType): ?string
    {
        try {
            $statement = $this->connection->prepare("SELECT creation_date FROM games WHERE slug = :current_game_slug");
            $statement->execute(['current_game_slug' => $currentGameSlug]);
            $currentGameDate = $statement->fetchColumn();

            $statement = $this->connection->prepare("SELECT slug FROM games WHERE creation_date > :current_game_date AND game_type = :game_type ORDER BY creation_date ASC LIMIT 1");
            $statement->execute(['current_game_date' => $currentGameDate, 'game_type' => $gameType]);
            return $statement->fetchColumn();
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }

    public function getCountOfGamesBySlug(string $slug, string $gameType): ?int
    {
        try {
            $statement = $this->connection->prepare("SELECT COUNT(*) FROM games WHERE slug LIKE :slug AND game_type = :game_type");
            $statement->execute(['slug' => $slug . '%',
                                 'game_type' => $gameType]);
            return $statement->fetchColumn();
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }
}
