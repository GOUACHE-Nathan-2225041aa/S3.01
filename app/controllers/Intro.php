<?php

namespace app\controllers;

use app\views\IntroView;

class IntroController
{
    public function execute(): void
    {
        $dataSpeaker = [
            'character_type' => 'adult',
            'character_head' => 'adult_head',
            'character_name' => 'Adult',
            'text' => 'Hey, <br> j’ai pris l’habitude de lire le journal dans le parc après mon boulot. <br> Cependant, j’ai récemment remarqué que de plus en plus d’articles sonnaient “faux” ou peu fiables. <br> Pourrais tu m’aider à les trouver ?'
        ];
        // example of $dataListener, remove sooner
        $dataListener = [
            'character_type' => '',
            'character_full' => '',
        ];
        (new IntroView())->show($dataSpeaker);
    }

}
