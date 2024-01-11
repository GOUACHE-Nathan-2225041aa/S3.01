<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Localization
{
    public function show(array $gameLocals, int $totalGamesCount, int $gamesPerPageCount): void
    {
        ob_start();
?>
<main>
    <h1>Localization</h1>
    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="errorMessage">
            <?= $_SESSION['errorMessage'] ?>
        </div>
        <?php unset($_SESSION['errorMessage']); ?>
    <?php endif; ?>
    <?php foreach ($gameLocals as $gameData): ?>
        <div>
            <h1>Game: <?= $gameData['game_id'] ?></h1>
            <?= $this->localizationForm($gameData, 'en') ?>
            <?= $this->localizationForm($gameData, 'fr') ?>
        </div>
    <?php endforeach; ?>
    <div>
        <?php for ($i = 1; $i <= ceil($totalGamesCount / $gamesPerPageCount); $i++): ?>
            <a href="/admin/localization?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</main>
<?php
        (new Layout('FakeGame - Localization', ob_get_clean(), 'Localization'))->show();
    }

    private function localizationForm($gameData, $lang): string
    {
        ob_start();
?>
<h2>Language : <?= $lang ?></h2>
<form method="POST" action="">
    <input type="hidden" name="game_id" value="<?= $gameData['game_id'] ?>">
    <input type="hidden" name="language" value="<?= $lang ?>">

    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="<?= $gameData['title-' . $lang] ?? '' ?>">

    <label for="hint">Hint</label>
    <textarea name="hint" id="hint" cols="30" rows="10"><?= $gameData['hint-' . $lang] ?? '' ?></textarea>

    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10"><?= $gameData['description-' . $lang] ?? '' ?></textarea>

    <button type="submit" name="save-localization">Save</button>
</form>
<?php
        return ob_get_clean();
    }
}
?>
