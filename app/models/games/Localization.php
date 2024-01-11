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

    public function getGameLocals(int $nbGames, int $page): array
    {
        try {
            $offset = ($page - 1) * $nbGames;

            $statement = $this->connection->prepare("SELECT id FROM games LIMIT :limit OFFSET :offset");
            $statement->bindParam(':limit', $nbGames, PDO::PARAM_INT);
            $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
            $statement->execute();
            $gameIds = $statement->fetchAll(PDO::FETCH_COLUMN);

            if (count($gameIds) === 0) {
                return [];
            }

            $placeholders = str_repeat('?,', count($gameIds) - 1) . '?';
            $statement = $this->connection->prepare("SELECT * FROM localization WHERE game_id IN ($placeholders) AND language IN ('en', 'fr')");
            $statement->execute($gameIds);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return [];
        }
    }

    public function save(array $data, string $gameId): void
    {
        $this->connection->beginTransaction();

        try {
            $statement = $this->connection->prepare("
                INSERT INTO localization (game_id, field, language, text) 
                VALUES (:game_id, :field, :language, :text)
                ON DUPLICATE KEY UPDATE text = :text
                ");

            foreach ($data as $localization) {
                $localization['game_id'] = $gameId;
                $statement->execute($localization);
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}
