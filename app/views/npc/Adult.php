<?php

namespace app\views\npc;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Adult
{
    public function show($loc): void
    {
        ob_start();
?>
<main id="main" data-npc="adult">
    <div class="game">
        <div id="adult">
            <div class="progress">
                <span><?= $loc['progress'] ?> : <?= $_SESSION['progress']['audio']['gamesDone'] ?? '' ?></span>
                <span><?= $loc['points'] ?> : <?= $_SESSION['progress']['audio']['totalPoints'] ?? '' ?></span>
            </div>
            <img id="adult" src="/assets/images/characters/adult/adult.png" alt="Adult character">
        </div>
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Adult', ob_get_clean(), 'dialogue', ['dialogue']))->show();
    }
}
?>
