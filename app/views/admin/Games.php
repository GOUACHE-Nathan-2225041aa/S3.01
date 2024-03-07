<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Games
{
    public function show(array $loc, array $games, int $pagesCount, int $currentPage): void
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
    <h1 class="title"><?= $loc['games'] ?></h1>
    <div class="games">
    <?php foreach ($games as $gameData): ?>
        <?= $this->game($loc, $gameData) ?>
    <?php endforeach; ?>
    </div>
    <div class="pages">
        <div class="pages-content">
        <?php for ($i = 1; $i <= $pagesCount; $i++): ?>
            <a class="<?= $currentPage === $i ? 'current-page' : '' ?>" href="/admin/games?page=<?= $i ?>"><?= $i ?></a>
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
        <li><b><?= $loc['gameUrl'] ?></b>: <a href="/games/<?= $gameData['slug'] ?>"><?= $gameData['slug'] ?></a></li>
        <li><b><?= $loc['gameId'] ?></b>: <?= $gameData['id'] ?></li>
        <li><b><?= $loc['gameType'] ?></b>: <?= $gameData['game_type'] ?></li>
        <li><b><?= $loc['gameCreationDate'] ?></b>: <?= $gameData['creation_date'] ?></li>
    </ul>
    <div class="btn-container">
        <button class="btn btn-danger btn-delete" data-game-id="<?= $gameData['id'] ?>" data-game-type="<?= $gameData['game_type'] ?>"><?= $loc['delete'] ?></button>
        <a class="btn btn-primary btn-update" href="/admin?update=<?= $gameData['id'] ?>&type=<?= $gameData['game_type'] ?>"><?= $loc['update'] ?></a>
    </div>
</div>
<?php
        return ob_get_clean();
    }
}
?>
