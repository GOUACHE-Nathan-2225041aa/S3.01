<?php

namespace app\controllers;

use app\views\Dialogue as DialogueView;

class Dialogue
{
    public function execute($speaker, $speaker_name, $speaker_text, $listener): void
    {

        $Q_young = "Salut, <br> je reste beaucoup sur Instagram et TikTok en ce moment. J’aime bien republier des photos et des faits rigolos mais mes parents m’ont dit de ne pas toujours faire confiance à ce que je peux voir ou lire sur les réseaux sociaux :( <br> Tu pourrais m’aider à démêler le vrai du faux s’il te plaît ? :’)";
        $A_young = "Pas de problèmes ! Montre moi ces photos et laisse moi t’expliquer pourquoi certaines d’entre elles sonnent faussent. <br> Si tu as un doute sur une photo, tu peux essayer de regarder des petits détails : <br> si tout le monde à bien 5 doigts, si le nombre de dents est cohérent etc...";
        $E_young = "Merci beaucoup ! Maintenant grâce à toi je sais reconnaître les vraies photos des fausses.";

        $Q_adult = "Hey, <br> j’ai pris l’habitude de lire le journal dans le parc après mon boulot. <br> Cependant, j’ai récemment remarqué que de plus en plus d’articles sonnaient “faux” ou peu fiables. <br> Pourrais tu m’aider à les trouver ?";
        $A_adult = "Laisse moi voir ces articles, je vais t’expliquer lesquels sont faux et pourquoi !";
        $E_adult = "Merci ! Désormais je penserais à aller vérifier les sources.";

        $Q_old = "Bonjour, <br> ...";
        $Q_old = "...";
        $E_old = "Merci ! <br> ...";

        $dataSpeaker = [
            'character_type' => $speaker,
            'character_head' => $speaker . '_head',
            'character_name' => $speaker_name,
            'text' => $speaker_text
        ];
        $dataListener = [
            'character_type' => $listener,
        ];
        (new DialogueView())->show($dataSpeaker,$dataListener);
    }

}
