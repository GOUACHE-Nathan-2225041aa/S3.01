<?php

namespace app\views\npc;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Old
{
    public function show(): void
    {
        ob_start();
?>
<main id="main" data-npc="old">
    <div class="game">
        <img id="old" src="/assets/images/characters/old/old.png" alt="Old character">
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Old', ob_get_clean(), 'dialogue', ['dialogue']))->show();
    }
}
?>
