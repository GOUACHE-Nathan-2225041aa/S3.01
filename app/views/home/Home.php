<?php

namespace app\views\home;

use app\views\layouts\Layout;

class Home // TODO = refactor this for better semantic
{
    public function show($loc): void
    {
        ob_start();
?>
<main>
    <div class="game">
        <div id="old">
            <div class="progress">
                <span><?= $loc['progress'] ?> : <?= $_SESSION['progress']['article']['gamesDone'] ?? '' ?></span>
                <span><?= $loc['points'] ?> : <?= $_SESSION['progress']['article']['totalPoints'] ?? '' ?></span>
            </div>
            <img onclick="window.location.href='/old'" src="/assets/images/characters/old/old.png" alt="Old character">
        </div>
        <div id="young">
            <div class="progress">
                <span><?= $loc['progress'] ?> : <?= $_SESSION['progress']['deep-fake']['gamesDone'] ?? '' ?></span>
                <span><?= $loc['points'] ?> : <?= $_SESSION['progress']['deep-fake']['totalPoints'] ?? '' ?></span>
            </div>
            <img onclick="window.location.href='/young'" src="/assets/images/characters/young/young.png" alt="Young character">
        </div>
        <div id="adult">
            <div class="progress">
                <span><?= $loc['progress'] ?> : <?= $_SESSION['progress']['audio']['gamesDone'] ?? '' ?></span>
                <span><?= $loc['points'] ?> : <?= $_SESSION['progress']['audio']['totalPoints'] ?? '' ?></span>
            </div>
            <img onclick="window.location.href='/adult'" src="/assets/images/characters/adult/adult.png" alt="Adult character">
        </div>
    </div>
</main>
<?php
        (new Layout('FakeGame - Home', ob_get_clean(), 'home', ['draggable']))->show();
    }
}
?>
