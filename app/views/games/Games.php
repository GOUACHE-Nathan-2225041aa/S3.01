<?php

namespace app\views\games;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Games
{
    public function show($gameData, $localizationData): void
    {
        ob_start();
?>
<script defer src="/assets/scripts/hint.js"></script>
<main id="game_screen">
    <div id="DeepFakeGUI">
        <div id="Titre">
            <h1><?= $localizationData['title'] ?></h1>
        </div>

        <div id="Contenu">
            <div id="DeepFakePicture">
                <img src="data:image/jpeg;base64,<?= $gameData['image'] ?>" alt="">
            </div>
            <?php if (isset($gameData['audio'])): ?>
                <div>
                    <audio id="audio" controls onloadeddata="this.volume = 0.2">
                        <source src="data:audio/mpeg;base64,<?= $gameData['audio'] ?>" type="audio/mpeg">
                    </audio>
                </div>
            <?php endif; ?>
            <form id="BoutonsChoix" method="POST" action="">
                <button type="submit" name="answer" value="1" id="BoutonReel">Réel</button>
                <span>OU</span>
                <button type="submit" name="answer" value="0" id="BoutonFake">Fake</button>
            </form>
        </div>

        <div id="Hint">
            <button id="btn-hint">J'ai besoin d'un indice...</button>
        </div>
    </div>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Games', ob_get_clean(), 'youngGame'))->show();
    }
}
