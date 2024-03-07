<?php

namespace app\controllers\api;

use app\models\games\Games as GamesModel;
use config\DataBase;
use PDO;
use PDOException;

class Games
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        $this->userAuth();

        header('Content-Type: application/json');
        $postData = json_decode(file_get_contents('php://input'), true);

        $gameId = htmlspecialchars($postData['game_id']) ?? null;
        $gameType = htmlspecialchars($postData['game_type']) ?? null;
        $param = htmlspecialchars($postData['param']) ?? null;

        if ($param === 'delete' && $gameId !== null) {
            try {
                (new GamesModel($this->GamePDO))->deleteGameById($gameId, $gameType);
                echo json_encode(['success' => 'Game deleted successfully']);
                exit();
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Invalid request']);
                exit();
            }
        }
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    private function userAuth(): void
    {
        if (!isset($_SESSION['username'])) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit();
        }
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit();
        }
    }
}
