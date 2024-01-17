<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Localization
{
    public function show(array $loc, array $gameLocals, int $totalGamesCount, int $gamesPerPageCount): void
    {
        ob_start();
?>
<main>
    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="errorMessage">
            <?= $_SESSION['errorMessage'] ?>
        </div>
        <?php unset($_SESSION['errorMessage']); ?>
    <?php endif; ?>
    <div class="forms">
        <h1 class="title"><?= $loc['localization'] ?></h1>
        <?php foreach ($gameLocals as $gameData): ?>
            <div>
                <h1 class="title"><?= $loc['game'] ?>: <?= $gameData['game_id'] ?></h1>
                <div class="form">
                    <?= $this->localizationForm($loc, $gameData, 'en') ?>
                    <?= $this->localizationForm($loc, $gameData, 'fr') ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pages">
        <div class="pages-content">
            <?php for ($i = 1; $i <= ceil($totalGamesCount / $gamesPerPageCount); $i++): ?>
                <a href="/admin/localization?page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
</main>
<?php
        (new Layout('FakeGame - Localization', ob_get_clean(), 'localization'))->show();
    }

    private function localizationForm($loc, $gameData, $lang): string
    {
        ob_start();
?>
<div class="single-form">
    <h2 class="title"><?= $loc['language'] ?> : <?= $lang ?></h2>
    <form method="POST" action="">
        <input type="hidden" name="game_id" value="<?= $gameData['game_id'] ?>">
        <input type="hidden" name="language" value="<?= $lang ?>">

        <div class="form-item">
            <label for="title"><?= $loc['title'] ?></label>
            <input type="text" name="title" id="title" value="<?= $gameData['title-' . $lang] ?? '' ?>">
        </div>

        <div class="form-item">
            <label for="hint"><?= $loc['hint'] ?></label>
            <textarea name="hint" id="hint" cols="30" rows="10"><?= $gameData['hint-' . $lang] ?? '' ?></textarea>
        </div>

        <div class="form-item">
            <label for="description"><?= $loc['description'] ?></label>
            <textarea name="description" id="description" cols="30" rows="10"><?= $gameData['description-' . $lang] ?? '' ?></textarea>
        </div>

        <div class="form-item">
            <button class="btn btn-primary" type="submit" name="save-localization"><?= $loc['save'] ?></button>
        </div>
    </form>
</div>
<?php
        return ob_get_clean();
    }
}
?>
