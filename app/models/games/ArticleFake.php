<?php

namespace app\models\games;

use PDO;
use PDOException;

class ArticleFake // TODO - refactor duplications
{
    public function __construct(private PDO $connection) {}

    public function createGame(array $gameData, array $localizationData): void
    {
        $this->connection->beginTransaction();

        try {
            $statement = $this->connection->prepare("INSERT INTO games (id, slug, game_type, creation_date) VALUES (:id, :slug, :game_type, :creation_date)");
            $statement->execute([
                'id' => $gameData['id'],
                'slug' => $gameData['slug'],
                'game_type' => $gameData['game_type'],
                'creation_date' => $gameData['creation_date']
            ]);

            $gameId = $gameData['id'];

            $statement = $this->connection->prepare("INSERT INTO article_fake_games (game_id, image, source, inserter_id, answer) VALUES (:game_id, :image, :source, :inserter_id, :answer)");
            $statement->execute([
                'game_id' => $gameId,
                'image' => $gameData['image'],
                'source' => $gameData['source'],
                'inserter_id' => $gameData['inserter_id'],
                'answer' => $gameData['answer'],
            ]);

            $statement = $this->connection->prepare("INSERT INTO localization (game_id, field, language, text) VALUES (:game_id, :field, :language, :text)");

            foreach ($localizationData as $localization) {
                $localization['game_id'] = $gameId;
                $statement->execute($localization);
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function getGame(string $gameId, string $language): ?array
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM article_fake_games WHERE game_id = :game_id");
            $statement->execute(['game_id' => $gameId]);
            $gameData = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $this->connection->prepare("SELECT * FROM localization WHERE game_id = :game_id AND language = :language");
            $statement->execute(['game_id' => $gameId, 'language' => $language]);
            $localizationData = $statement->fetchAll(PDO::FETCH_ASSOC);

            return array_merge($gameData, ['localization' => $localizationData]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }

    public function getFirstGame(string $gameType, string $language): ?array
    {
        try {
            $statement = $this->connection->prepare("SELECT id FROM games WHERE game_type = :game_type ORDER BY creation_date ASC LIMIT 1");
            $statement->execute(['game_type' => $gameType]);
            $firstGameId = $statement->fetchColumn();

            if ($firstGameId === false) {
                return null;
            }

            $statement = $this->connection->prepare("SELECT * FROM article_fake_games WHERE game_id = :game_id");
            $statement->execute(['game_id' => $firstGameId]);
            $gameData = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $this->connection->prepare("SELECT * FROM localization WHERE game_id = :game_id AND language = :language");
            $statement->execute(['game_id' => $firstGameId, 'language' => $language]);
            $localizationData = $statement->fetchAll(PDO::FETCH_ASSOC);

            return array_merge($gameData, ['localization' => $localizationData]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }

    public function getNextGame(string $currentGameId, string $gameType, string $language): ?array
    {
        try {
            $statement = $this->connection->prepare("SELECT creation_date FROM games WHERE id = :current_game_id");
            $statement->execute(['current_game_id' => $currentGameId]);
            $currentGameDate = $statement->fetchColumn();

            $statement = $this->connection->prepare("SELECT id FROM games WHERE creation_date > :current_game_date AND game_type = :game_type ORDER BY creation_date ASC LIMIT 1");
            $statement->execute(['current_game_date' => $currentGameDate, 'game_type' => $gameType]);
            $nextGameId = $statement->fetchColumn();

            if ($nextGameId === false) {
                return null;
            }

            $statement = $this->connection->prepare("SELECT * FROM article_fake_games WHERE game_id = :game_id");
            $statement->execute(['game_id' => $nextGameId]);
            $gameData = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $this->connection->prepare("SELECT * FROM localization WHERE game_id = :game_id AND language = :language");
            $statement->execute(['game_id' => $nextGameId, 'language' => $language]);
            $localizationData = $statement->fetchAll(PDO::FETCH_ASSOC);

            return array_merge($gameData, ['localization' => $localizationData]);
        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
            return null;
        }
    }

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
