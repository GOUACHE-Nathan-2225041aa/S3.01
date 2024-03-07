<?php

namespace app\models\games;

use PDO;
use PDOException;

class Audio
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

            $statement = $this->connection->prepare("INSERT INTO audio_fake_games (game_id, image, audio, source, inserter_id, answer) VALUES (:game_id, :image, :audio, :source, :inserter_id, :answer)");
            $statement->execute([
                'game_id' => $gameId,
                'image' => $gameData['image'],
                'audio' => $gameData['audio'],
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
            $statement = $this->connection->prepare("SELECT * FROM audio_fake_games WHERE game_id = :game_id");
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

    public function updateGame(array $gameData): void
    {
        try {
            $this->connection->beginTransaction();

            $statement = $this->connection->prepare("UPDATE games SET slug = :slug WHERE id = :id");
            $statement->execute([
                'id' => $gameData['id'],
                'slug' => $gameData['slug'],
            ]);

            $statement = $this->connection->prepare("UPDATE audio_fake_games SET image = :image, audio = :audio, source = :source, inserter_id = :inserter_id, answer = :answer WHERE game_id = :game_id");
            $statement->execute([
                'game_id' => $gameData['id'],
                'image' => $gameData['image'],
                'audio' => $gameData['audio'],
                'source' => $gameData['source'],
                'inserter_id' => $gameData['inserter_id'],
                'answer' => $gameData['answer'],
            ]);

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}
