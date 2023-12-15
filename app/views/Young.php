<?php

namespace app\views;

class Young
{
    public function show($imgUrl, $titre): void
    {
        ob_start();
?>
    <section id="game_screen">
<?php
        include('DeepFakeGUI.php');
?>
    </section>
<?php
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
?>
