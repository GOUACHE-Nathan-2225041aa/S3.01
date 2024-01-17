<?php

namespace app\models\games;

use PDO;
use PDOException;

class Progress
{
    public function __construct(private PDO $connection) {}

    public function saveProgress(array $data): void
    {
        $this->connection->beginTransaction();

        try {
            $statement = $this->connection->prepare("
                INSERT INTO games (type, game_index, slug, done, points, hint, account_id)
                VALUES (:type, :game_index, :slug, :done, :points, :hint, :account_id)
            ");

            foreach ($data['games'] as $game) {
                $statement->execute([
                    'type' => $game['type'],
                    'game_index' => $game['game_index'],
                    'slug' => $game['slug'],
                    'done' => $game['done'],
                    'points' => $game['points'],
                    'hint' => $game['hint'],
                    'account_id' => $data['user_id'],
                ]);
            }

            $statement = $this->connection->prepare("
                INSERT INTO checkpoints (type, checkpoint_index, account_id)
                VALUES (:type, :checkpoint_index, :account_id)
            ");

            foreach ($data['checkpoints'] as $checkpoint) {
                $statement->execute([
                    'type' => $checkpoint['type'],
                    'checkpoint_index' => $checkpoint['checkpoint_index'],
                    'account_id' => $data['user_id'],
                ]);
            }

            $statement = $this->connection->prepare("
                INSERT INTO progress (type, games_done, total_points, account_id)
                VALUES (:type, :games_done, :total_points, :account_id)
            ");

            foreach ($data['progress'] as $progress) {
                $statement->execute([
                    'type' => $progress['type'],
                    'games_done' => $progress['games_done'],
                    'total_points' => $progress['total_points'],
                    'account_id' => $data['user_id'],
                ]);
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function deleteProgress(string $userId): void
    {
        $this->connection->beginTransaction();

        try {
            $statement = $this->connection->prepare("
                DELETE FROM games WHERE account_id = :account_id
            ");
            $statement->execute(['account_id' => $userId]);

            $statement = $this->connection->prepare("
                DELETE FROM checkpoints WHERE account_id = :account_id
            ");
            $statement->execute(['account_id' => $userId]);

            $statement = $this->connection->prepare("
                DELETE FROM progress WHERE account_id = :account_id
            ");
            $statement->execute(['account_id' => $userId]);

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function getProgress(string $userId): array
    {
        $data = [];

        try {
            $statement = $this->connection->prepare("
                SELECT * FROM games WHERE account_id = :account_id
            ");
            $statement->execute(['account_id' => $userId]);
            $data['games'] = $statement->fetchAll(PDO::FETCH_ASSOC);

            $statement = $this->connection->prepare("
                SELECT * FROM checkpoints WHERE account_id = :account_id
            ");
            $statement->execute(['account_id' => $userId]);
            $data['checkpoints'] = $statement->fetchAll(PDO::FETCH_ASSOC);

            $statement = $this->connection->prepare("
                SELECT * FROM progress WHERE account_id = :account_id
            ");
            $statement->execute(['account_id' => $userId]);
            $data['progress'] = $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log('Failed to prepare or execute statement: ' . $e->getMessage());
        }

        return $data;
    }
}
