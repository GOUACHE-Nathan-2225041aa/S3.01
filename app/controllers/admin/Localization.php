<?php

namespace app\controllers\admin;

use app\services\DataService;
use app\services\Localization as LocalizationService;
use app\views\admin\Localization as LocalizationView;
use app\models\games\Localization as LocalizationModel;
use app\models\games\Games as GamesModel;
use config\DataBase;
use PDO;
use PDOException;

class Localization
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(array $data): void
    {
        $params = $data['query'] ?? [];

        $this->userAuth();
        $totalGamesCount = (new GamesModel($this->GamePDO))->getTotalGamesCount();
        $gamesPerPageCount = 6;
        $page = 1;

        if (isset($params['page'])) {
            $page = (int) htmlspecialchars($params['page']);
        }

        $games = (new LocalizationModel($this->GamePDO))->getGameLocals($gamesPerPageCount, $page);

        if (count($games) === 0) {
            $_SESSION['errorMessage'] = 'No games found';
            header('Location: /admin');
            exit();
        }

        $games = DataService::mergeGameLocals($games);

        $loc = (new LocalizationService())->getArray('localization');
        (new LocalizationView())->show($loc, $games, $totalGamesCount, $gamesPerPageCount, $page);
    }

    public function save(array $data): void
    {
        $postData = $data['post'];

        $this->userAuth();

        $gameId = htmlspecialchars($postData['game_id']);
        $language = htmlspecialchars($postData['language']);

        $localizationData = [
            [
                'field' => 'title',
                'language' => $language,
                'text' => htmlspecialchars($postData['title']),
            ],
            [
                'field' => 'hint',
                'language' => $language,
                'text' => htmlspecialchars($postData['hint']),
            ],
            [
                'field' => 'description',
                'language' => $language,
                'text' => htmlspecialchars($postData['description']),
            ],
        ];

        try {
            (new LocalizationModel($this->GamePDO))->save($localizationData, $gameId);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $_SESSION['errorMessage'] = 'Error while saving localization data';
            header('Location: /admin/localization');
            exit();
        }

        $_SESSION['errorMessage'] = 'Localization saved successfully';
        header('Location: /admin/localization');
        exit();
    }

    private function userAuth(): void
    {
        if (!isset($_SESSION['username'])) {
            $_SESSION['errorMessage'] = 'Veuillez vous connecter';
            header('Location: /login');
            exit();
        }
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            $_SESSION['errorMessage'] = 'Vous n\'avez pas les droits pour accéder à cette page';
            header('Location: /');
            exit();
        }
    }
}
