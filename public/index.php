<?php

use app\controllers\admin\Admin as AdminController;
use app\controllers\connections\Login as LoginController;
use app\controllers\connections\Logout as LogoutController;
use app\controllers\connections\Recovery as RecoveryController;
use app\controllers\connections\Signup as SignupController;
use app\controllers\home\Home as HomeController;
use app\controllers\Intro\Intro as IntroController;
use app\controllers\welcome\Welcome as WelcomeController;
use app\controllers\young\Young as YoungController;
use app\controllers\api\Dialogues as DialoguesController;
use app\controllers\games\Games as GamesController;
use app\controllers\api\Hint as HintController;
use app\controllers\errors\Errors as ErrorsController;
use app\controllers\games\Result as ResultController;

use app\services\Localization;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

(new Localization());

try {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email_verification'])) {
            (new SignupController())->sendVerificationURL($_POST);
        }

        if (isset($_POST['signup'])) {
            $path = $_SERVER['REQUEST_URI'];
            $parts = explode('/', $path);
            $code = end($parts);
            (new SignupController())->signup($_POST, $code);
        }

        if (isset($_POST['login'])) {
            (new LoginController())->login($_POST);
        }

        if (isset($_POST['recovery'])) {
            $path = $_SERVER['REQUEST_URI'];
            $parts = explode('/', $path);
            $code = end($parts);
            (new RecoveryController())->recovery($_POST, $code);
        }

        if (isset($_POST['recovery_email_verification'])) {
            (new RecoveryController())->sendVerificationURL($_POST);
        }

        if (isset($_POST['create-game'])) {
            (new AdminController())->createGame($_POST, $_FILES);
        }

        if (isset($_POST['answer'])) {
            (new ResultController())->execute($_POST);
        }

        // TODO - refactor this
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/api/dialogues') {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                (new DialoguesController())->execute();
            } else {
                header('HTTP/1.0 403 Forbidden');
                echo 'Access denied';
                exit;
            }
        }

        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/api/hint') {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                (new HintController())->execute();
            } else {
                header('HTTP/1.0 403 Forbidden');
                echo 'Access denied';
                exit;
            }
        }
    }

    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]) {
            case 'home':
                (new HomeController())->execute();
                break;

            case 'login':
                (new LoginController())->execute();
                break;
            case 'signup':
                if (isset($route[1])) {
                    (new SignupController())->verificationURL($route[1]);
                    break;
                }
                (new SignupController())->execute();
                break;
            case 'recovery':
                if (isset($route[1])) {
                    (new RecoveryController())->verificationURL($route[1]);
                    break;
                }
                (new RecoveryController())->execute();
                break;
            case 'logout':
                (new LogoutController())->execute();
                break;

            case 'admin':
                (new AdminController())->execute();
                break;

            case 'intro':
                (new IntroController())->execute();
                break;

            case '/':
                (new WelcomeController())->execute();
                break;

            case 'young':
                (new YoungController())->execute();
                break;

            case 'games':
                if (isset($route[1]) && count($route) == 2) {
                    (new GamesController())->execute($route[1]);
                    break;
                }
                if (isset($route[1]) && isset($route[2]) && $route[2] === 'result') {
                    header('Location: /games/' . $route[1]);
                    break;
                }
                (new ErrorsController())->notFound();
                break;

            default:
                (new ErrorsController())->notFound();
                break;
        }
    }
} catch (Exception) {

}
