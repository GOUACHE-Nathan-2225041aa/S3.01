<?php

namespace app\views;

class Home
{
    public function show($characterState): void
    {
        ob_start();
?>

<section id="game_screen">

    <img id='bg' src="/assets/images/background/park.png">

    <img id='old' src="/assets/images/characters/old/<?= $characterState['old']?>">

    <img id='young' src="/assets/images/characters/young/<?= $characterState['young']?>">

    <img id='adult' src="/assets/images/characters/adult/<?= $characterState['adult']?>">
    
</section>

<?php
        (new Layout('FakeGame - Home', ob_get_clean(), 'home'))->show();
    }
}
?>
