<?php

namespace app\views\welcome;

use app\views\layouts\Layout;

class Welcome
{
    public function show(): void
    {
        ob_start();
?>
<main>
    <div>
        <h1>Welcome blah blah blah WIP</h1>
    </div>
    <a href="/intro">Intro</a>
    <a href="/home">Start The Game</a>
</main>
<?php
        (new Layout('FakeGame - Welcome', ob_get_clean()))->show();
    }
}
?>
