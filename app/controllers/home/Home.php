<?php

namespace app\controllers\home;

use app\views\home\Home as HomeView;

class Home
{
    public function execute(): void
    {
        (new HomeView())->show();
    }
}
