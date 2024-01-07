<?php

namespace app\controllers\games;

use app\views\games\Result as ResultView;
use app\models\games\DeepFake as DeepFakeModel;
use app\models\games\Article as ArticleModel;
use app\models\games\Audio as AudioModel;
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

    public function execute(): void
    {
        if (!isset($_SESSION['answer_form_submitted']) || !$_SESSION['answer_form_submitted']) {
            isset($_SESSION['current_game']) ? header('Location: /games/' . $_SESSION['current_game']) : header('Location: /home');
            exit();
        }

        $postData = $_SESSION['answer_form_data'];

        unset($_SESSION['answer_form_submitted']);
        unset($_SESSION['answer_form_data']);

        $game = (new GamesModel($this->GamePDO))->getGameBySlug($_SESSION['current_game']);

        if ($game === null) {
            header('Location: /home');
            exit();
        }

        $this->showGameResult($game, $postData);
    }

    private function showGameResult($game, $postData): void
    {
        $gameData = null;
        $npc = null;
        $data = [];

        if ($game['game_type'] === 'deep-fake') {
            $gameData = (new DeepFakeModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);
            $npc = 'young';
        }
        if ($game['game_type'] === 'article') {
            $gameData = (new ArticleModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);
            $npc = 'old';
        }
        if ($game['game_type'] === 'audio') {
            $gameData = (new AudioModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);
            $data['audio'] = base64_encode($gameData['audio']);
            $npc = 'adult';
        }

        $localizationData = $this->getTextFromLocalData($gameData['localization'], $_SESSION['language']);

        $nextGameSlug = (new GamesModel($this->GamePDO))->getNextGameSlug($game['slug'], $game['game_type']);

        // TODO - maybe make the redirection based in progress and not last game (redirection to end dialogue)
        if ($nextGameSlug === '') {
            $_SESSION[$npc] = 'end';
        }

        $data += [
            'source' => $gameData['source'],
            'image' => base64_encode($gameData['image']),
            'userAnswer' => intval(htmlspecialchars($postData['answer'])),
            'correctAnswer' => intval($gameData['answer']),
            'description' => $localizationData['description'],
            'nextGameSlug' => $nextGameSlug,
        ];

        (new ResultView())->show($data, $npc);
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
