<?php

namespace app\views\games;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class DeepFake
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
            <form id="BoutonsChoix" method="POST" action="/games/<?= $gameData['slug'] ?>/result">
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
        (new Layout('FakeGame - DeepFake', ob_get_clean(), 'youngGame'))->show();
    }
}
