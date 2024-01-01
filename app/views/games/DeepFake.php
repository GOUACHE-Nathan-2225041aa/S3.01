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
<script src="/assets/scripts/hint.js"></script>
<main id="game_screen">
    <div id="DeepFakeGUI">
        <div id="Titre">
            <h1><?= $localizationData['title'] ?></h1>
        </div>

        <div id="Contenu">
            <div id="DeepFakePicture">
                <img src="data:image/jpeg;base64,<?= $gameData['image'] ?>" alt="">
            </div>
            <div id="BoutonsChoix">
                <button type="submit" name="reponse" value="true" id="BoutonReel">Réel</button>
                <br>
                <label>OU</label>
                <br>
                <button type="submit" name="reponse" value="false" id="BoutonFake">Fake</button>
            </div>
        </div>

        <div id="Hint">
            <button id="Understood" onclick="showHint()">J'ai besoin d'un indice...</button>
        </div>
    </div>
    <?= (new Dialogue())->getDialogueTemplate('closeHint()') ?>
</main>
<?php
        (new Layout('FakeGame - DeepFake', ob_get_clean(), 'youngGame'))->show();
    }
}
