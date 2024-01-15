<?php

namespace app\controllers\home;

use app\views\home\Home as HomeView;

class Home // TODO - rework this class
{
    public function execute(): void
    {
        (new HomeView())->show();
    }
}
