<?php

namespace app\controllers\api;

use app\models\games\DeepFake as DeepFakeModel;
use app\models\games\Games as GamesModel;
use config\DataBase;
use PDO;

class Hint
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        header('Content-Type: application/json');

        $gameSlug = null;
        $referer = $_SERVER['HTTP_REFERER'] ?? null;

        if ($referer !== null) {
            $parts = explode('/', $referer);
            $gameSlug = end($parts);
        }

        if ($gameSlug === null) {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }

        $game = (new GamesModel($this->GamePDO))->getGameBySlug($gameSlug);

        if ($game['game_type'] === 'deep-fake') {
            $hint = (new DeepFakeModel($this->GamePDO))->getHint($game['id'], $_SESSION['language']);
            echo json_encode($hint);
            exit();
        }

        echo json_encode(['error' => 'Invalid request']);
    }
}
