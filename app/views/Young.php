<?php

namespace app\views;

class Young
{
    public function show($imgUrl, $titre): void
    {
        ob_start();
        $_SESSION["hint"] = true;
        include('DeepFakeGUI.php');
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
