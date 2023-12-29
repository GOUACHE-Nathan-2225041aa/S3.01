<?php

namespace app\views\young;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Young
{
    public function show(): void
    {
        ob_start();
?>
<script src="/assets/scripts/dialogue.js" defer></script>
<main id="game_screen" data-npc="young">
    <img id='bg' src="/assets/images/background/park.png">
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
?>
