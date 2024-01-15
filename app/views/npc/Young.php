<?php

namespace app\views\npc;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Young
{
    public function show(): void
    {
        ob_start();
?>
<main id="main" data-npc="young">
    <div class="game">
        <img id="young" src="/assets/images/characters/young/young.png" alt="Young character">
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Young', ob_get_clean(), 'dialogue', ['dialogue', 'draggable']))->show();
    }
}
?>
