<?php

namespace app\views\games;

use app\views\layouts\Layout;

class Result
{
    public function show($data, $npc): void
    {
        ob_start();
?>
<main id="main">
    <div class="game">
        <h1 class="title <?= $data['userAnswer'] === $data['correctAnswer'] ? 'correct' : 'wrong'?>"><?= $data['userAnswer'] === $data['correctAnswer'] ? 'Correct Answer' : 'Wrong Answer' ?></h1>
        <div class="middle-game">
            <div class="left-container">
                <?php if (isset($data['image'])): ?>
                <div>
                    <img data-src="data:image/jpeg;base64,<?= $data['image'] ?>" src="" alt="">
                </div>
                <?php endif; ?>
                <?php if (isset($data['audio'])): ?>
                    <audio controls onloadeddata="this.volume = 0.2">
                        <source src="data:audio/mpeg;base64,<?= $data['audio'] ?>" type="audio/mpeg">
                    </audio>
                <?php endif; ?>
                <?php if (isset($data['source'])): ?>
                    <a class="source" href="<?= $data['source'] ?>" target="_blank">Source</a>
                <?php endif; ?>
            </div>
            <p class="description"><?= $data['description'] ?></p>
        </div>
        <button class="btn btn-primary" onclick="window.location.href='<?= $data['nextGameSlug'] !== '' ? '/games/' . $data['nextGameSlug'] : '/' . $npc ?>'">Understood!</button>
    </div>
</main>
<?php
        (new Layout('FakeGame - Result', ob_get_clean(), 'result', ['draggable', 'image']))->show();
    }
}
?>
