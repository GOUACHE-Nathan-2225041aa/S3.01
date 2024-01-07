<?php

namespace app\controllers\games;

use app\views\games\Games as GamesView;
use app\models\games\DeepFake as DeepFakeModel;
use app\models\games\Article as ArticleModel;
use app\models\games\Audio as AudioModel;
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

        $this->gameProgress(htmlspecialchars($game['slug']));

        $this->showGame($game, htmlspecialchars($slug));
    }

    private function showGame($game, $slug): void
    {
        $gameData = null;
        $data = [];

        if ($game['game_type'] === 'deep-fake') $gameData = (new DeepFakeModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);
        if ($game['game_type'] === 'article') $gameData = (new ArticleModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);
        if ($game['game_type'] === 'audio') {
            $gameData = (new AudioModel($this->GamePDO))->getGame($game['id'], $_SESSION['language']);
            $data['audio'] = base64_encode($gameData['audio']);
        }

        $localizationData = $this->getTextFromLocalData($gameData['localization'], $_SESSION['language']);
        $data += [
            'source' => $gameData['source'],
            'image' => base64_encode($gameData['image']),
            'slug' => $slug,
        ];

        (new GamesView())->show($data, $localizationData);
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

    private function gameProgress($newGameSlug): void // TODO - maybe add next game slug here
    {
        if (isset($_SESSION['current_game'])) $_SESSION['last_game'] = $_SESSION['current_game'];
        $_SESSION['current_game'] = $newGameSlug;
    }
}
