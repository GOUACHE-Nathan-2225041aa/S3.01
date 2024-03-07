<?php

namespace app\views\partials;

use app\services\Localization as LocalizationService;

class Header
{
    public function getHeader(): string
    {
        $loc = (new LocalizationService())->getArray('header');
        ob_start();
?>
<header>
    <nav class="navbar">
        <a href="/"><?= $loc['intro'] ?></a>
        <a href="/home"><?= $loc['home'] ?></a>
        <?php if (!isset($_SESSION['username'])): ?>
        <a href="/login"><?= $loc['account'] ?></a>
        <?php else: ?>
        <a href="/logout"><?= $loc['logout'] ?></a>
        <?php endif; ?>
        <button id="save-progress"><?= $loc['saveProgress'] ?></button>
        <button id="load-progress"><?= $loc['loadProgress'] ?></button>
        <?php if (isset($_SESSION['admin']) || $_SESSION['admin']): ?>
        <a href="/admin"><?= $loc['admin'] ?></a>
        <?php endif; ?>
        <select id="language-selector">
            <option <?= $_SESSION['language'] === 'fr' ? 'selected' : ''?> value="fr"><?= $loc['fr'] ?></option>
            <option <?= $_SESSION['language'] === 'en' ? 'selected' : ''?> value="en"><?= $loc['en'] ?></option>
        </select>
    </nav>
</header>
<?php
        return ob_get_clean();
    }
}
?>
