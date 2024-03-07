<?php

namespace app\views\games;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Games
{
    public function show($loc, $gameData, $localizationData): void
    {
        ob_start();
?>
<main id="main">
    <div class="game">
        <h1 class="title"><?= $localizationData['title'] ?></h1>
        <div class="middle-game">
            <div class="left-container">
                <div class="img-container">
                    <img id="zoom-img" data-src="data:image/jpeg;base64,<?= $gameData['image'] ?>" src="" alt="">
                </div>
                <?php if (isset($gameData['audio'])): ?>
                    <audio id="audio" controls onloadeddata="this.volume = 0.2">
                        <source src="data:audio/mpeg;base64,<?= $gameData['audio'] ?>" type="audio/mpeg">
                    </audio>
                <?php endif; ?>
            </div>
            <form class="answer-from" method="POST" action="">
                <button class="btn btn-primary" type="submit" name="answer" value="1"><?= $loc['true'] ?></button>
                <button class="btn btn-danger" type="submit" name="answer" value="0"><?= $loc['false'] ?></button>
            </form>
        </div>
        <button class="btn btn-danger" id="btn-hint"><?= $loc['hint'] ?></button>
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Games', ob_get_clean(), 'game', ['hint', 'draggable', 'image']))->show();
    }
}
