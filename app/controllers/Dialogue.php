<?php

namespace app\controllers;

use app\views\DialogueView;

class DialogueController
{
    public function execute($speaker, $speaker_name, $speaker_text, $listener): void
    {

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
