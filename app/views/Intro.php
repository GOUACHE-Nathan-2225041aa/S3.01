<?php

namespace app\views;

class IntroView
{
    public function show($dataSpeaker, $dataListener = []): void
    {
        ob_start();
?>
<?php include('partials/dialogueTemplate.php') ?>
<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
