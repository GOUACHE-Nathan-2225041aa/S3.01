<?php

use app\controllers\admin\Admin as AdminController;
use app\controllers\connections\Login as LoginController;
use app\controllers\connections\Logout as LogoutController;
use app\controllers\connections\Recovery as RecoveryController;
use app\controllers\connections\Signup as SignupController;
use app\controllers\home\Home as HomeController;
use app\controllers\Intro\Intro as IntroController;
use app\controllers\npc\Young as YoungController;
use app\controllers\api\Dialogues as DialoguesController;
use app\controllers\games\Games as GamesController;
use app\controllers\api\Hint as HintController;
use app\controllers\errors\Errors as ErrorsController;
use app\controllers\games\Result as ResultController;
use app\controllers\npc\Old as OldController;
use app\controllers\npc\Adult as AdultController;
use app\controllers\admin\Localization as LocalizationController;
use app\controllers\admin\Games as AdminGamesController;
use app\controllers\api\Games as ApiGamesController;
use app\controllers\api\Language as ApiLanguageController;
use app\controllers\api\Progress as ProgressController;

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
            (new AdminController())->createGame($_POST, $_FILES, false);
        }

        if (isset($_POST['update-game'])) {
            (new AdminController())->createGame($_POST, $_FILES, true);
        }

        if (isset($_POST['save-localization'])) {
            (new LocalizationController())->save($_POST);
        }

        if (isset($_POST['answer'])) {
            $_SESSION['answer_form_submitted'] = true;
            $_SESSION['answer_form_data'] = $_POST;
            $currentGame = $_SESSION['games'][$_SESSION['current_game']['type']][$_SESSION['current_game']['index']]['slug'];
            header('Location: /games/' . $currentGame . '/result');
            exit;
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

        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/api/games') {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                (new ApiGamesController())->execute();
            } else {
                header('HTTP/1.0 403 Forbidden');
                echo 'Access denied';
                exit;
            }
        }

        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/api/language') {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                (new ApiLanguageController())->execute();
            } else {
                header('HTTP/1.0 403 Forbidden');
                echo 'Access denied';
                exit;
            }
        }

        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/api/progress') {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                (new ProgressController())->execute();
            } else {
                header('HTTP/1.0 403 Forbidden');
                echo 'Access denied';
                exit;
            }
        }
    }

    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $params = [];
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        $route = ($urlParts['path'] === '/') ? '/' : explode('/', trim($urlParts['path'], '/'));

        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $params);
        }

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

            case '/':
                (new IntroController())->execute();
                break;

            case 'young':
                (new YoungController())->execute();
                break;

            case 'old':
                (new OldController())->execute();
                break;

            case 'adult':
                (new AdultController())->execute();
                break;

            case 'admin':
                if (isset($route[1]) && $route[1] === 'localization') {
                    (new LocalizationController())->execute($params);
                    break;
                }
                if (isset($route[1]) && $route[1] === 'games') {
                    (new AdminGamesController())->execute($params);
                    break;
                }
                if (count($route) > 1) {
                    (new ErrorsController())->notFound();
                    break;
                }
                (new AdminController())->execute();
                break;

            case 'games':
                if (isset($route[1]) && count($route) == 2) {
                    (new GamesController())->execute($route[1]);
                    break;
                }
                if (isset($route[1]) && isset($route[2]) && $route[2] === 'result') {
                    (new ResultController())->execute();
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
    header('HTTP/1.0 500 Internal Server Error');
    exit();
}
