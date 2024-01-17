<?php

namespace app\views\npc;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Young
{
    public function show($loc): void
    {
        ob_start();
?>
<main id="main" data-npc="young">
    <div class="game">
        <div id="young">
            <div class="progress">
                <span><?= $loc['progress'] ?> : <?= $_SESSION['progress']['deep-fake']['gamesDone'] ?? '' ?></span>
                <span><?= $loc['points'] ?> : <?= $_SESSION['progress']['deep-fake']['totalPoints'] ?? '' ?></span>
            </div>
            <img src="/assets/images/characters/young/young.png" alt="Young character">
        </div>
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Young', ob_get_clean(), 'dialogue', ['dialogue', 'draggable']))->show();
    }
}
?>
