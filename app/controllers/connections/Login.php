<?php

namespace app\controllers\connections;

use app\models\User as UserModel;
use app\views\connections\Login as LoginView;
use config\DataBase;
use PDO;

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
        (new LoginView())->show();
    }

    public function login(array $postData): void
    {
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

        if ($user === null || !password_verify($postData['password'], htmlspecialchars($user['password']))) {
            $_SESSION['errorMessage'] = 'Nom d\'utilisateur ou mot de passe incorrect';
            header('Location: /login');
            exit();
        }

        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['id'] = $user['id'];

        header('Location: /home');
        exit();
    }
}
