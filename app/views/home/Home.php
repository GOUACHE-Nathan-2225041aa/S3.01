<?php

namespace app\views\home;

use app\views\layouts\Layout;

class Home // TODO = refactor this for better semantic
{
    public function show(): void
    {
        ob_start();
?>
<main>
    <div class="game">
        <img id="old" onclick="window.location.href='/old'" src="/assets/images/characters/old/old.png" alt="Old character">
        <img id="young" onclick="window.location.href='/young'" src="/assets/images/characters/young/young.png" alt="Young character">
        <img id="adult" onclick="window.location.href='/adult'" src="/assets/images/characters/adult/adult.png" alt="Adult character">
    </div>
</main>
<?php
        (new Layout('FakeGame - Home', ob_get_clean(), 'home', ['draggable']))->show();
    }
}
?>
