<?php

namespace app\views;

use app\views\layouts\Layout;

class Young
{
    public function show($sourceUrl, $title, $hint): void
    {
        ob_start();
        include('DeepFakeGUI.php');
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
