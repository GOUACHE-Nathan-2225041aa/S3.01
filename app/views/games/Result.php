<?php

namespace app\views\games;

use app\views\layouts\Layout;

class Result
{
    public function show($data): void
    {
        ob_start();
?>
<main id="game_screen">
    <div id="DeepFakeGUI">
        <div id="Answer">
            <h1><?= $data['userAnswer'] === $data['correctAnswer'] ? 'Correct Answer' : 'Wrong Answer' ?></h1>
        </div>

        <div id="Frame">
            <div id="DFP">
                <?php if (isset($data['image'])): ?>
                    <img id="ImageOnTheSide" src="data:image/jpeg;base64,<?= $data['image'] ?>" alt="">
                <?php endif; ?>
                <?php if (isset($data['source'])): ?>
                    <a id="Source" href="<?= $data['source'] ?>">Source</a>
                <?php endif; ?>
            </div>

            <div id="Explications">
                <p><?= $data['description'] ?></p>
            </div>
        </div>

        <div id="Next">
            <button id="btn-hint" onclick="window.location.href='/games/<?= $data['nextGameSlug'] ?>'">J'ai tout compris!</button>
        </div>

    </div>
</main>
<?php
        (new Layout('FakeGame - Result', ob_get_clean(), 'youngGame'))->show();
    }
}
?>
