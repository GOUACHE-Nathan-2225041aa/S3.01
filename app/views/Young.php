<?php

namespace app\views;

class YoungView
{
    public function show($imgUrl): void
    {
        ob_start();
include('DeepFakeGUI.php');
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
?>
