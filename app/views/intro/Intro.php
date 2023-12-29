<?php

namespace app\views\intro;

use app\views\layouts\Layout;

class Intro
{
    public function show($dataSpeaker, $dataListener = [], $next_page = '/home'): void
    {
        ob_start();
?>
<?php include('partials/Dialogue.php') ?>
<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
