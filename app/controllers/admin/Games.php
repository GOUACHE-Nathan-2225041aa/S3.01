<?php

namespace app\controllers\admin;

use app\services\Localization as LocalizationService;
use app\views\admin\Games as AdminGamesView;
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

    public function execute(array $data): void
    {
        $params = $data['query'];

        $this->userAuth();
        $totalGamesCount = (new GamesModel($this->GamePDO))->getTotalGamesCount();
        $gamesPerPageCount = 10;
        $page = 1;

        if (isset($params['page'])) {
            $page = (int) htmlspecialchars($params['page']);
        }

        $offset = ($page - 1) * $gamesPerPageCount;

        $games = (new GamesModel($this->GamePDO))->getGames($gamesPerPageCount, $offset);

        if (count($games) === 0) {
            $_SESSION['errorMessage'] = 'No games found';
            header('Location: /admin');
            exit();
        }

        $pagesCount = ceil($totalGamesCount / $gamesPerPageCount);

        $loc = (new LocalizationService())->getArray('games');
        (new AdminGamesView())->show($loc, $games, $pagesCount);
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
