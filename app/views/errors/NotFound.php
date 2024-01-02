<?php

namespace app\views\errors;

use app\views\layouts\Layout;

class NotFound
{
    public function show(): void
    {
        ob_start();
?>
<main>
    <h1>404</h1>
    <p>Page not found</p>
</main>
<?php
        (new Layout('FakeGame - 404', ob_get_clean()))->show();
    }
}
?>
