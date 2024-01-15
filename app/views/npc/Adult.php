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
<main id="main" data-npc="adult">
    <div class="game">
        <img id="adult" src="/assets/images/characters/adult/adult.png" alt="Adult character">
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Adult', ob_get_clean(), 'dialogue', ['dialogue']))->show();
    }
}
?>
