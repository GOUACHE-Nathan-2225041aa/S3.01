<?php

namespace app\views;

class DialogueView
{
    public function show($dataSpeaker, $dataListener): void
    {
        ob_start();
?>
    <div id="game_screen">
        <img id='bg' src="/assets/images/background/park.png">
        <?php include('partials/dialogueTemplate.php') ?>
    </div>

<?php
        (new Layout('FakeGame - Dialogue', ob_get_clean(), 'interaction'))->show();
    }
}
?>
