<?php

namespace app\controllers\errors;

use app\views\errors\NotFound as NotFoundView;

class Errors
{
    public function notFound(): void
    {
        (new NotFoundView())->show();
    }
}
