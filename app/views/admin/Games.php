<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Games
{
    public function show(array $loc, array $games, int $pagesCount): void
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
    <div class="games">
    <h1 class="title"><?= $loc['games'] ?></h1>
    <?php foreach ($games as $gameData): ?>
        <?= $this->game($loc, $gameData) ?>
    <?php endforeach; ?>
    </div>
    <div class="pages">
        <div class="pages-content">
        <?php for ($i = 1; $i <= $pagesCount; $i++): ?>
            <a href="/admin/games?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
        </div>
    </div>
</main>
<?php
        (new Layout('FakeGame - Games', ob_get_clean(), 'admingames', ['deletegame']))->show();
    }

    private function game($loc, $gameData): string
    {
        ob_start();
?>
<div class="game">
    <ul>
        <li><?= $loc['gameUrl'] ?>: <a href="/games/<?= $gameData['slug'] ?>"><?= $gameData['slug'] ?></a></li>
        <li><?= $loc['gameId'] ?>: <?= $gameData['id'] ?></li>
        <li><?= $loc['gameType'] ?>: <?= $gameData['game_type'] ?></li>
        <li><?= $loc['gameCreationDate'] ?>: <?= $gameData['creation_date'] ?></li>
    </ul>
    <div>
        <button class="btn btn-danger btn-delete" data-game-id="<?= $gameData['id'] ?>" data-game-type="<?= $gameData['game_type'] ?>"><?= $loc['delete'] ?></button>
        <button class="btn btn-primary btn-update" data-game-id="<?= $gameData['id'] ?>" data-game-type="<?= $gameData['game_type'] ?>"><?= $loc['update'] ?></button>
    </div>
</div>
<?php
        return ob_get_clean();
    }
}
?>
