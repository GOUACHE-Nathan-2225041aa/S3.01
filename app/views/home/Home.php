<?php

namespace app\views\home;

use app\views\layouts\Layout;

class Home // TODO = refactor this for better semantic
{
    public function show($characterState): void
    {
        ob_start();
?>

<section id="game_screen">

    <img id='bg' src="/assets/images/background/park.png">

    <img id='old' onclick="window.location.href='/old'" src="/assets/images/characters/old/<?= $characterState['old']?>">

    <img id='young' onclick="window.location.href='/young'" src="/assets/images/characters/young/<?= $characterState['young']?>">

    <img id='adult' onclick="window.location.href='/adult'" src="/assets/images/characters/adult/<?= $characterState['adult']?>">
    
</section>

<?php
        (new Layout('FakeGame - Home', ob_get_clean(), 'home'))->show();
    }
}
?>
