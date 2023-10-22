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
            'text' => 'Hello my friend!'
        ];
        // example of $dataListener, remove sooner
        $dataListener = [
            'character_type' => '',
            'character_full' => '',
        ];
        (new IntroView())->show($dataSpeaker);
    }

}
