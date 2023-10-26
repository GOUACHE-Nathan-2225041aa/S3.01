<?php

namespace app\controllers;

use app\views\Dialogue as DialogueView;

class Dialogue
{
    public function execute($speaker, $speaker_name, $speaker_text, $listener, $next_page): void
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
        (new DialogueView())->show($dataSpeaker,$dataListener,$next_page);
    }

}
