<?php

namespace app\controllers;

use app\views\IntroView;

class IntroController
{
    public function execute(): void
    {
        $text_intro = "Avec l'émergence du numérique et de l'intelligence artificielles, les Fakes News sont de plus en présentes et prennent facilement de l'ampleur. Elles sont dans tout les domaines, et touchent tout les âges. <br> Le but de ce serious game est de vous apprendre de manière ludique à les repérer pour mieux vous en protéger. <br> Je vais vous guider tout au long du jeu, ensemble, rétablissons la vérité !";
        $Q_adult = "Hey, <br> j’ai pris l’habitude de lire le journal dans le parc après mon boulot. <br> Cependant, j’ai récemment remarqué que de plus en plus d’articles sonnaient “faux” ou peu fiables. <br> Pourrais tu m’aider à les trouver ?";

        $dataSpeaker = [
            'character_type' => 'me',
            'character_head' => 'me_head',
            'character_name' => 'Moi',
            'text' => $text_intro
        ];
        // example of $dataListener, remove sooner
        $dataListener = [
            'character_type' => '',
            'character_full' => '',
        ];
        (new IntroView())->show($dataSpeaker);
    }

}
