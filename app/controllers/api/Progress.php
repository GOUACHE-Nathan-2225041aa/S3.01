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
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['saveClient']) && $data['saveClient']) {
            $this->loadSaveData($data);
            echo json_encode(['success' => 'Progress loaded']);
            exit();
        }

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

        if (isset($_SESSION['id'])) $data['user_id'] = $_SESSION['id'];

        return $data;
    }

    private function userAuth(): void
    {
        if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
            $this->saveToClient();
        }
    }

    private function saveToClient(): void
    {
        $data = $this->prepareData();

        $data['saveClient'] = true;

        echo json_encode($data);
        exit();
    }

    public function loadSaveData($data): void
    {
        if ($data === []) {
            header('Location: /home');
            exit();
        }

        $_SESSION['games'] = [];
        $_SESSION['progress'] = [];
        $_SESSION['checkpoints'] = [];

        foreach ($data['games'] as $game) {
            $_SESSION['games'][$game['type']][$game['game_index']] = [
                'done' => $game['done'],
                'hint' => $game['hint'],
                'points' => $game['points'],
                'slug' => $game['slug'],
            ];
        }

        foreach ($data['progress'] as $progress) {
            $_SESSION['progress'][$progress['type']] = [
                'gamesDone' => $progress['games_done'],
                'totalPoints' => $progress['total_points'],
            ];
        }

        foreach ($data['checkpoints'] as $checkpoint) {
            $_SESSION['checkpoints'][$checkpoint['type']][$checkpoint['checkpoint_index']] = true;
        }
    }
}
