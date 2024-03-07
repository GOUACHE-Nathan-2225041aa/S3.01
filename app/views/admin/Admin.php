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
    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="errorMessage">
            <?= $_SESSION['errorMessage'] ?>
        </div>
        <?php unset($_SESSION['errorMessage']); ?>
    <?php endif; ?>
    <div class="profile">
        <h1><?= $loc['profile'] ?></h1>
        <ul>
            <li><?= $loc['status'] ?>: <?= $user['admin'] ? 'Admin' : 'User' ?></li>
            <li>UUID: <?= $user['id'] ?></li>
            <li><?= $loc['username'] ?>: <?= $user['username'] ?></li>
            <li><?= $loc['email'] ?>: <?= $user['email'] ?></li>
        </ul>
    </div>
    <div class="links">
        <a href="/admin/localization"><?= $loc['localization'] ?></a>
        <a href="/admin/games"><?= $loc['games'] ?></a>
    </div>
    <div class="game-form">
        <?= $gameData ? (new GameForm())->getEditForm($loc, $gameData) : (new GameForm())->getNewForm($loc) ?>
    </div>
</main>
<?php
        (new Layout('FakeGame - Admin', ob_get_clean(), 'admin', ['draggable', 'image']))->show();
    }
}
