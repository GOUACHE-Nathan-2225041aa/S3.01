<?php

namespace app\controllers;

use app\views\Intro as IntroController;

class Intro
{
    public function execute(): void
    {
        $text_intro = "Avec l'émergence du numérique et de l'intelligence artificielles, les Fakes News sont de plus en présentes et prennent facilement de l'ampleur. Elles sont dans tout les domaines, et touchent tout les âges. <br> Le but de ce serious game est de vous apprendre de manière ludique à les repérer pour mieux vous en protéger. <br> Je vais vous guider tout au long du jeu, ensemble, rétablissons la vérité !";
        $text_outro = "bravo";

        $dataSpeaker = [
            'character_type' => 'me',
            'character_head' => 'me_head',
            'character_name' => 'Moi',
            'text' => $text_intro
        ];
        (new IntroController())->show($dataSpeaker);
    }

}
