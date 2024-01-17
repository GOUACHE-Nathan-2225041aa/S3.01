<?php

namespace app\views\npc;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Old
{
    public function show($loc): void
    {
        ob_start();
?>
<main id="main" data-npc="old">
    <div class="game">
        <div id="old">
            <div class="progress">
                <span><?= $loc['progress'] ?> : <?= $_SESSION['progress']['article']['gamesDone'] ?? '' ?></span>
                <span><?= $loc['points'] ?> : <?= $_SESSION['progress']['article']['totalPoints'] ?? '' ?></span>
            </div>
            <img src="/assets/images/characters/old/old.png" alt="Old character">
        </div>
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Old', ob_get_clean(), 'dialogue', ['dialogue']))->show();
    }
}
?>
