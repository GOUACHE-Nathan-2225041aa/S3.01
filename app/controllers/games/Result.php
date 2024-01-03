<?php

namespace app\controllers\games;

use app\views\games\Result as ResultView;
use app\models\games\DeepFake as DeepFakeModel;
use app\models\games\Games as GamesModel;
use config\DataBase;
use PDO;

class Result
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute($postData): void
    {
        $referer = htmlspecialchars($_SERVER['HTTP_REFERER']);
        $refererSlug = explode('/', $referer)[4];

        $game = (new GamesModel($this->GamePDO))->getGameBySlug($refererSlug);

        if ($game === null) {
            header('Location: /');
            exit();
        }

        if ($game['game_type'] === 'deep-fake') {
            $this->resultDeepFakeGame($game, $refererSlug);
        }
    }

    private function resultDeepFakeGame($game, $currentGameSlug): void
    {
        $gameData = (new DeepFakeModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);

        $localizationData = $this->getTextFromLocalData($gameData['localization'], $_SESSION['language']);

        $nextGameSlug = (new GamesModel($this->GamePDO))->getNextGameSlug($currentGameSlug, $game['game_type']);

        $data = [
            'source' => $gameData['source'],
            'image' => base64_encode($gameData['image']),
            'userAnswer' => intval(htmlspecialchars($_POST['answer'])),
            'correctAnswer' => intval($gameData['answer']),
            'description' => $localizationData['description'],
            'nextGameSlug' => $nextGameSlug,
        ];

        (new ResultView())->show($data);
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
