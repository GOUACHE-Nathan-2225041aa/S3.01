<?php

namespace app\views\intro;

use app\views\layouts\Layout;

class Intro // TODO - rework this entirely
{
    public function show(): void
    {
        ob_start();
?>

<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
