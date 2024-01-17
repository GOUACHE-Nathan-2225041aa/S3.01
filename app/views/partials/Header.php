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
        <a href="/"><?= $loc['welcome'] ?></a>
        <a href="/intro"><?= $loc['intro'] ?></a>
        <a href="/home"><?= $loc['home'] ?></a>
        <a href="/login"><?= $loc['login'] ?></a>
        <a href="/signup"><?= $loc['signup'] ?></a>
        <a href="/admin"><?= $loc['admin'] ?></a>
        <a href="/about"><?= $loc['about'] ?></a>
    </nav>
</header>
<?php
        return ob_get_clean();
    }
}
?>
