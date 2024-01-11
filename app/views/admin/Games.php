<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Games
{
    public function show(array $games, int $pagesCount): void
    {
        ob_start();
?>
<main>
    <script src="/assets/scripts/deletegame.js" defer></script>
    <h1>Games</h1>
    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="errorMessage">
            <?= $_SESSION['errorMessage'] ?>
        </div>
        <?php unset($_SESSION['errorMessage']); ?>
    <?php endif; ?>
    <?php foreach ($games as $gameData): ?>
        <?= $this->game($gameData) ?>
    <?php endforeach; ?>
    <div>
        <?php for ($i = 1; $i <= $pagesCount; $i++): ?>
            <a href="/admin/games?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</main>
<?php
        (new Layout('FakeGame - Games', ob_get_clean()))->show();
    }

    private function game($gameData): string
    {
        ob_start();
?>
<div>
    <ul>
        <li>Game URL: <a href="/games/<?= $gameData['slug'] ?>"><?= $gameData['slug'] ?></a></li>
        <li>Game ID: <?= $gameData['id'] ?></li>
        <li>Game Type: <?= $gameData['game_type'] ?></li>
        <li>Game Creation Date: <?= $gameData['creation_date'] ?></li>
    </ul>
    <button class="btn-delete" data-game-id="<?= $gameData['id'] ?>" data-game-type="<?= $gameData['game_type'] ?>">Delete</button>
</div>
<?php
        return ob_get_clean();
    }
}
?>
