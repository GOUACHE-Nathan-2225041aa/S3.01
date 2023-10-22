<?php

use app\controllers\IntroController;
use app\controllers\YoungController;;
use app\controllers\HomeController;

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
            default:
                error_log('404 Not Found. Not implemented yet');
                break;
        }
    }
} catch (Exception) {

}
