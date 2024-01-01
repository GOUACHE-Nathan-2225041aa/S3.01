<?php

namespace app\controllers\games;

use app\views\games\DeepFake as DeepFakeView;
use app\models\games\DeepFake as DeepFakeModel;
use app\models\games\Games as GamesModel;
use config\DataBase;
use PDO;

class Games
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute($slug): void
    {
        $game = (new GamesModel($this->GamePDO))->getGameBySlug(htmlspecialchars($slug));

        if ($game === null) {
            header('Location: /');
            exit();
        }

        if ($game['game_type'] === 'deep-fake') {
           $this->showDeepFakeGame($game);
        }
    }

    private function showDeepFakeGame($game): void
    {
        error_log(print_r($game, true));
        error_log(print_r($_SESSION, true));
        $gameData = (new DeepFakeModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);

        $localizationData = $this->getTextFromLocalData($gameData['localization'], $_SESSION['language']);
        $data = [
            'source' => $gameData['source'],
            'image' => base64_encode($gameData['image']),
        ];

        (new DeepFakeView())->show($data, $localizationData);
    }

    private function getTextFromLocalData($localizationData, $language): array
    {
        $result = [];
        foreach ($localizationData as $localization) {
            if ($localization['language'] === $language) {
                $result[$localization['field']] = $localization['text'];
            }
        }
        return $result;
    }
}
