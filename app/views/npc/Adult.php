<?php

namespace app\views\npc;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Adult
{
    public function show(): void
    {
        ob_start();
?>
<script src="/assets/scripts/dialogue.js" defer></script>
<main id="game_screen" data-npc="adult">
    <img id='bg' src="/assets/images/background/park.png">
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Adult', ob_get_clean()))->show();
    }
}
?>