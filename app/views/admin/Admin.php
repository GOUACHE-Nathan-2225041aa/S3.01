<?php

namespace app\views\admin;

use app\views\layouts\Layout;
use app\views\partials\GameForm;

class Admin
{
    public function show($loc, $user, $gameData = null): void
    {
        ob_start();
?>
<main>
    <div>
        <div class="profile">
            <ul>
                <li><b><?= $loc['status'] ?></b>: <?= $user['admin'] ? 'Admin' : 'User' ?></li>
                <li><b>UUID</b>: <?= $user['id'] ?></li>
                <li><b><?= $loc['username'] ?></b>: <?= $user['username'] ?></li>
                <li><b><?= $loc['email'] ?></b>: <?= $user['email'] ?></li>
            </ul>
        </div>
        <div class="links">
            <a href="/admin/localization"><?= $loc['localization'] ?></a>
            <a href="/admin/games"><?= $loc['games'] ?></a>
            <a href="/admin"><?= $loc['createGame'] ?></a>
        </div>
    </div>
    <div class="game-form">
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="errorMessage">
                <?= $_SESSION['errorMessage'] ?>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>
        <?= $gameData ? (new GameForm())->getEditForm($loc, $gameData) : (new GameForm())->getNewForm($loc) ?>
    </div>
</main>
<?php
        (new Layout('FakeGame - Admin', ob_get_clean(), 'admin', ['draggable', 'image', 'gameform']))->show();
    }
}
