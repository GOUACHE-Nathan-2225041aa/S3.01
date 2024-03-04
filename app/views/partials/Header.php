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
        <a href="/login"><?= $loc['account'] ?></a>
        <button id="save-progress"><?= $loc['saveProgress'] ?></button>
        <button id="load-progress"><?= $loc['loadProgress'] ?></button>
        <a href="/admin"><?= $loc['admin'] ?></a>
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
