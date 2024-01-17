<?php

namespace app\controllers\api;

use app\models\games\Localization as LocalizationModel;
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

        if (!isset($_SESSION['current_game'])) {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }

//        $game = (new GamesModel($this->GamePDO))->getGameBySlug(htmlspecialchars($_SESSION['current_game']));

        $currentGameIndex = $_SESSION['current_game']['index'];
        $currentGameType = $_SESSION['current_game']['type'];
        $currentGameSlug = $_SESSION['games'][$currentGameType][$currentGameIndex]['slug'];

        $game = (new GamesModel($this->GamePDO))->getGameBySlug($currentGameSlug);

        $hint = (new LocalizationModel($this->GamePDO))->getHint($game['id'], $_SESSION['language']);

        if ($hint === null) {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }

        if (!$_SESSION['games'][$currentGameType][$currentGameIndex]['hint']) {
            $_SESSION['games'][$currentGameType][$currentGameIndex]['hint'] = true;
            $_SESSION['games'][$currentGameType][$currentGameIndex]['points'] -= 0.5;
        }

        echo json_encode($hint);
        exit();
    }
}
