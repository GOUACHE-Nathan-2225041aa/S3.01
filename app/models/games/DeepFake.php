<?php

namespace app\models\games;

use PDO;
use PDOException;

class DeepFake // TODO - refactor duplications
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

            $statement = $this->connection->prepare("INSERT INTO deep_fake_games (game_id, image, source, inserter_id, answer) VALUES (:game_id, :image, :source, :inserter_id, :answer)");
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

    public function updateGame(array $gameData, array $localizationData): void
    {
        $this->connection->beginTransaction();

        try {
            $this->updateGameData($gameData);
            $this->updateLocalizationData($localizationData, $gameData['id']);

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    private function updateGameData(array $gameData): void
    {
        $statement = $this->connection->prepare("UPDATE games SET slug = :slug, game_type = :game_type, creation_date = :creation_date WHERE id = :id");
        $statement->execute([
            'id' => $gameData['id'],
            'slug' => $gameData['slug'],
            'game_type' => $gameData['game_type'],
            'creation_date' => $gameData['creation_date']
        ]);
    }

    private function updateLocalizationData(array $localizationData, string $gameId): void
    {
        $deleteStatement = $this->connection->prepare("DELETE FROM localization WHERE game_id = :game_id");
        $deleteStatement->execute(['game_id' => $gameId]);

        $insertStatement = $this->connection->prepare("INSERT INTO localization (game_id, field, language, text) VALUES (:game_id, :field, :language, :text)");

        foreach ($localizationData as $localization) {
            $localization['game_id'] = $gameId;
            $insertStatement->execute($localization);
        }
    }

    public function getGame(string $gameId, string $language): ?array
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM deep_fake_games WHERE game_id = :game_id");
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
}
