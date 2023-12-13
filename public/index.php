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

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Tout les dialogues du jeu en FR (à mettre dans un fichier à part)
$Q_young = "Salut, <br> je reste beaucoup sur Instagram et TikTok en ce moment. J’aime bien republier des photos et des faits rigolos mais mes parents m’ont dit de ne pas toujours faire confiance à ce que je peux voir ou lire sur les réseaux sociaux :( <br> Tu pourrais m’aider à démêler le vrai du faux s’il te plaît ? :’)";
$A_young = "Pas de problèmes ! Montre moi ces photos et laisse moi t’expliquer pourquoi certaines d’entre elles sonnent faussent. <br> Si tu as un doute sur une photo, tu peux essayer de regarder des petits détails : <br> si tout le monde à bien 5 doigts, si le nombre de dents est cohérent etc...";
$E_young = "Merci beaucoup ! Maintenant grâce à toi je sais reconnaître les vraies photos des fausses.";
// ---
$Q_adult = "Hey, <br> j’ai pris l’habitude de lire le journal dans le parc après mon boulot. <br> Cependant, j’ai récemment remarqué que de plus en plus d’articles sonnaient “faux” ou peu fiables. <br> Pourrais tu m’aider à les trouver ?";
$A_adult = "Laisse moi voir ces articles, je vais t’expliquer lesquels sont faux et pourquoi !";
$E_adult = "Merci ! Désormais je penserais à aller vérifier les sources.";
// ---
$Q_old = "Bonjour, <br> ...";
$A_old = "...";
$E_old = "Merci ! <br> ...";
// ----------------------------------------------------------------

try {
    if (isset($_SERVER['REQUEST_URI'])) {
        $route = $_SERVER['REQUEST_URI'];

        switch ($route) {
            case '/dialogue':
            case '/':
                (new IntroController())->execute();
                break;
            case '/young':
                (new YoungController())->execute();
                break;
            case '/home':
                (new HomeController())->execute();
                break;

            // Les dialogues avec le Jeune :
            case '/dialogue-Qy' :
                (new DialogueController())->execute('young', 'Titouan', $Q_young, 'young', '/dialogue-Ay');
                break;
            case '/dialogue-Ay' :
                (new DialogueController())->execute('me', 'Moi', $A_young, 'young','/young');
                break;
            case '/dialogue-Ey' :
                (new DialogueController())->execute('young', 'Titouan', $E_young, 'young','/home');
                break;

            // Les dialogues avec l'Adulte :
            case '/dialogue-Qa' :
                (new DialogueController())->execute('adult', 'Thomas', $Q_adult, 'adult','/dialogue-Aa');
                break;
            case '/dialogue-Aa' :
                (new DialogueController())->execute('me', 'Moi', $A_adult, 'adult','/adult');
                break;
            case '/dialogue-Ea' :
                (new DialogueController())->execute('adult', 'Thomas', $E_adult, 'adult','/home');
                break;

            // Les dialogues avec la Grand-Mère :
            case '/dialogue-Qo' :
                (new DialogueController())->execute('old', 'Grand-mère', $Q_old, 'old','/dialogue-Ao');
                break;
            case '/dialogue-Ao' :
                (new DialogueController())->execute('me', 'Moi', $A_old, 'old','/old');
                break;
            case '/dialogue-Eo' :
                (new DialogueController())->execute('old', 'Grand-mère', $E_old, 'old','/home');
                break;

            case '/login':
                (new LoginController())->execute();
                break;
            case '/signup':
                (new SignupController())->execute();
                break;
            case '/recovery':
                (new RecoveryController())->execute();
                break;
            case '/logout':
                (new LogoutController())->execute();
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
