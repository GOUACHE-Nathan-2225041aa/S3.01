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

    public function getTotalGamesCount(): ?int
    {
        try {
            $statement = $this->connection->prepare("SELECT COUNT(*) FROM games");
            $statement->execute();
            return $statement->fetchColumn();
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }

    public function getGames($nbGames, $offset): array
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM games ORDER BY creation_date DESC LIMIT :limit OFFSET :offset");
            $statement->bindParam(':limit', $nbGames, PDO::PARAM_INT);
            $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return [];
        }
    }

    public function deleteGameById(string $gameId, string $gameType): void
    {
        $gameQuery = [
            'deep-fake' => "DELETE FROM deep_fake_games WHERE game_id = :game_id",
            'audio' => "DELETE FROM audio_fake_games WHERE game_id = :game_id",
            'article' => "DELETE FROM article_fake_games WHERE game_id = :game_id",
        ];

        $this->connection->beginTransaction();

        try {
            if (!isset($gameQuery[$gameType])) return;

            $statement = $this->connection->prepare($gameQuery[$gameType]);
            $statement->execute(['game_id' => $gameId]);

            $statement = $this->connection->prepare("DELETE FROM localization WHERE game_id = :game_id");
            $statement->execute(['game_id' => $gameId]);

            $statement = $this->connection->prepare("DELETE FROM games WHERE id = :id");
            $statement->execute(['id' => $gameId]);

            $this->connection->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
