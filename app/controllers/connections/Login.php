<?php

namespace app\controllers\connections;

use app\models\User as UserModel;
use app\views\connections\Login as LoginView;
use config\DataBase;
use PDO;
use app\services\Localization as LocalizationService;
use app\models\games\Progress as ProgressModel;

class Login
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnectionAccount();
    }

    public function execute(): void
    {
        if (isset($_SESSION['username'])) {
            header('Location: /home');
            exit();
        }
        $loc = (new LocalizationService())->getArray('login');
        (new LoginView())->show($loc);
    }

    public function login(array $data): void
    {
        $postData = $data['post'];
        $user = new UserModel($this->PDO);

        if (!isset($postData['username'])) {
            $_SESSION['errorMessage'] = 'Veuillez entrer un nom d\'utilisateur';
            header('Location: /login');
            exit();
        }

        if (!isset($postData['password'])) {
            $_SESSION['errorMessage'] = 'Veuillez entrer un mot de passe';
            header('Location: /login');
            exit();
        }

        $user = $user->getUserByUsername(htmlspecialchars(strtolower($postData['username'])));

        if ($user === null || !password_verify(htmlspecialchars($postData['password']), htmlspecialchars($user['password']))) {
            $_SESSION['errorMessage'] = 'Nom d\'utilisateur ou mot de passe incorrect';
            header('Location: /login');
            exit();
        }

        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['id'] = $user['id'];

        $this->loadSaveData();

        header('Location: /home');
        exit();
    }

    public function loadSaveData(): void
    {
        $data = (new ProgressModel($this->PDO))->getProgress($_SESSION['id']);

        if ($data === []) {
            header('Location: /home');
            exit();
        }

        $_SESSION['games'] = [];
        $_SESSION['progress'] = [];
        $_SESSION['checkpoints'] = [];

        foreach ($data['games'] as $game) {
            $_SESSION['games'][$game['type']][$game['game_index']] = [
                'done' => $game['done'],
                'hint' => $game['hint'],
                'points' => $game['points'],
                'slug' => $game['slug'],
            ];
        }

        foreach ($data['progress'] as $progress) {
            $_SESSION['progress'][$progress['type']] = [
                'gamesDone' => $progress['games_done'],
                'totalPoints' => $progress['total_points'],
            ];
        }

        foreach ($data['checkpoints'] as $checkpoint) {
            $_SESSION['checkpoints'][$checkpoint['type']]['index'] = $checkpoint['checkpoint_index'];
        }
    }
}
