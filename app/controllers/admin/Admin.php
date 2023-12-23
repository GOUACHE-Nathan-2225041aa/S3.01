<?php

namespace app\controllers\admin;

use app\views\admin\Admin as AdminView;
use app\models\User as UserModel;
use app\models\games\DeepFake as DeepFakeModel;
use config\DataBase;
use PDO;

class Admin
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnection();
    }

    public function execute(): void
    {
        // TODO - refactor this
        $this->userAuth();
        (new AdminView())->show((new UserModel($this->PDO))->getUserByUsername($_SESSION['username']));
    }

    public function createGame($postData): void
    {
        $this->userAuth();

        if (!isset($postData['game_type'])) {
            $_SESSION['errorMessage'] = 'Missing game type';
            header('Location: /admin');
            exit();
        }

        if ($postData['game_type'] === 'deep-fake') {
            $this->gameDeepFake($postData);
        }
    }

    // TODO - complete this (WIP)
    private function gameDeepFake($postData): void
    {
        $gameData = [
            'title' => htmlspecialchars($postData['title']),
            'image' => htmlspecialchars($postData['image']),
            'answer' => htmlspecialchars($postData['answer']),
            'hint' => htmlspecialchars($postData['hint']),
            'description' => htmlspecialchars($postData['description']),
            'source' => htmlspecialchars($postData['source']),
            'game_type' => htmlspecialchars($postData['game_type']),
        ];

        // example of localization data
        $localizationData = [
            [
                'field' => 'title',
                'language' => 'en',
                'text' => 'some text',
            ],
            [
                'field' => 'title',
                'language' => 'fr',
                'text' => 'some text',
            ],
            [
                'field' => 'description',
                'language' => 'en',
                'text' => 'some text',
            ],
            [
                'field' => 'description',
                'language' => 'fr',
                'text' => 'some text',
            ],
        ];

        error_log(print_r($gameData, true));
//        (new DeepFakeModel($this->PDO))->createGame($data);
        $_SESSION['errorMessage'] = 'Game created successfully';
        header('Location: /admin');
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
