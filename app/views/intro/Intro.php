<?php

namespace app\views\intro;

use app\views\layouts\Layout;
use app\views\partials\Dialogue;

class Intro
{
    public function show(): void
    {
        ob_start();
?>
<main>
    <?= (new Dialogue())->getDialogueTemplate() ?>
</main>
<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro', ['dialogue']))->show();
    }
}
?>
