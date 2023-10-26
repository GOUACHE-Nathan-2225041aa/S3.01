<?php

namespace app\views;

class Intro
{
    public function show($dataSpeaker, $dataListener = [], $next_page = '/home'): void
    {
        ob_start();
?>
<?php include('partials/dialogueTemplate.php') ?>
<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
