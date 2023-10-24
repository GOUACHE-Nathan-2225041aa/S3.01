<?php

use app\controllers\IntroController;
use app\controllers\YoungController;
use app\controllers\HomeController;
use app\controllers\DialogueController;
use app\controllers\VerifDeepFakeController;

session_start();

require_once '../config/autoloader.php';

try {
    if (isset($_SERVER['REQUEST_URI'])) {
        $route = $_SERVER['REQUEST_URI'];

        switch ($route) {
            case '/':
                (new IntroController())->execute();
                break;
            case '/young':
                (new YoungController())->execute();
                break;
            case '/home':
                (new HomeController())->execute();
                break;
            case '/dialogue':
                (new DialogueController())->execute('old', 'Grand-mère', 'Bonjour jeune homme, aurais tu vu mon chien par hasard ?', 'young');
                break;
            default:
                error_log('404 Not Found. Not implemented yet');
                break;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
        (new VerifDeepFakeController())->verifierDeepFake($_POST);
    }
} catch (Exception) {

}
