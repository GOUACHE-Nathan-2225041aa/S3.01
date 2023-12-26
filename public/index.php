<?php

use app\controllers\Intro as IntroController;
use app\controllers\Young as YoungController;
use app\controllers\Home as HomeController;
use app\controllers\Dialogue as DialogueController;
use app\controllers\VerifDeepFake as VerifDeepFakeController;
use app\controllers\connections\Login as LoginController;
use app\controllers\connections\Signup as SignupController;
use app\controllers\connections\Recovery as RecoveryController;
use app\controllers\connections\Logout as LogoutController;
use app\controllers\admin\Admin as AdminController;
use app\services\Localization;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Tout les dialogues du jeu en FR (à mettre dans un fichier à part)
// TODO - refactor this
$Q_young = (new Localization())->getText('dialogues', ['young', 'question']);
$A_young = (new Localization())->getText('dialogues', ['young', 'answer']);
$E_young = (new Localization())->getText('dialogues', ['young', 'end']);
// ---
$Q_adult = (new Localization())->getText('dialogues', ['adult', 'question']);
$A_adult = (new Localization())->getText('dialogues', ['adult', 'answer']);
$E_adult = (new Localization())->getText('dialogues', ['adult', 'end']);
// ---
$Q_old = (new Localization())->getText('dialogues', ['old', 'question']);
$A_old = (new Localization())->getText('dialogues', ['old', 'answer']);
$E_old = (new Localization())->getText('dialogues', ['old', 'end']);
// ----------------------------------------------------------------

try {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['reponse'])) {
            $_SESSION['verificationDeepfake'] = true;
            (new VerifDeepFakeController())->verifyDeepFake($_POST);
        }

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
    }

    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]) {
            case 'dialogue':
                break;
            case '/':
                (new IntroController())->execute();
                break;
            case 'young':
                (new YoungController())->execute();
                break;
            case 'home':
                (new HomeController())->execute();
                break;

            // Les dialogues avec le Jeune :
            case 'dialogue-Qy' :
                (new DialogueController())->execute('young', 'Titouan', $Q_young, 'young', '/dialogue-Ay');
                break;
            case 'dialogue-Ay' :
                $_SESSION['picturesDone'] = 0;
                (new DialogueController())->execute('me', 'Moi', $A_young, 'young','/young');
                break;
            case 'dialogue-Ey' :
                (new DialogueController())->execute('young', 'Titouan', $E_young, 'young','/home');
                break;

            // Les dialogues avec l'Adulte :
            case 'dialogue-Qa' :
                (new DialogueController())->execute('adult', 'Thomas', $Q_adult, 'adult','/dialogue-Aa');
                break;
            case 'dialogue-Aa' :
                (new DialogueController())->execute('me', 'Moi', $A_adult, 'adult','/adult');
                break;
            case 'dialogue-Ea' :
                (new DialogueController())->execute('adult', 'Thomas', $E_adult, 'adult','/home');
                break;

            // Les dialogues avec la Grand-Mère :
            case 'dialogue-Qo' :
                (new DialogueController())->execute('old', 'Grand-mère', $Q_old, 'old','/dialogue-Ao');
                break;
            case 'dialogue-Ao' :
                (new DialogueController())->execute('me', 'Moi', $A_old, 'old','/old');
                break;
            case 'dialogue-Eo' :
                (new DialogueController())->execute('old', 'Grand-mère', $E_old, 'old','/home');
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

            default:
                error_log('404 Not Found. Not implemented yet');
                break;
        }
    }
} catch (Exception) {

}
