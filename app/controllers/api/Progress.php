<?php

namespace app\controllers\api;

use app\models\games\Progress as ProgressModel;
use config\DataBase;
use PDO;

class Progress
{
    private PDO $AccountPDO;

    public function __construct()
    {
        $this->AccountPDO = DataBase::getConnectionAccount();
    }

    public function execute(): void
    {
        header('Content-Type: application/json');

        $this->userAuth();

        $data = $this->prepareData();

        (new ProgressModel($this->AccountPDO))->deleteProgress($_SESSION['id']);
        (new ProgressModel($this->AccountPDO))->saveProgress($data);

        echo json_encode(['success' => 'Progress saved']);
        exit();
    }

    private function prepareData(): array
    {
        if (!isset($_SESSION['games'])) return [];

        $gamesByType = $_SESSION['games'];
        $data = [];

        foreach ($gamesByType as $key => $games) {
            for ($i = 0; $i < count($games); $i++) {
                $data['games'][] = [
                    'done' => $games[$i]['done'],
                    'game_index' => $i,
                    'hint' => $games[$i]['hint'],
                    'points' => $games[$i]['points'],
                    'slug' => $games[$i]['slug'],
                    'type' => $key,
                ];
            }
        }

        $progressByType = $_SESSION['progress'];

        foreach ($progressByType as $key => $progress) {
            $data['progress'][] = [
                'games_done' => $progress['gamesDone'],
                'total_points' => $progress['totalPoints'],
                'type' => $key,
            ];
        }

        $checkpointsByType = $_SESSION['checkpoints'];

        foreach ($checkpointsByType as $key => $checkpoints) {
            $data['checkpoints'][] = [
                'checkpoint_index' => $checkpoints['index'],
                'type' => $key,
            ];
        }

        $data['user_id'] = $_SESSION['id'];

        return $data;
    }

    private function userAuth(): void
    {
        if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }
    }
}
