<?php

namespace app\controllers\connections;

class Logout
{
    public function execute(): void
    {
        session_destroy();
        header('Location: /');
        exit();
    }
}
