<?php

namespace app\controllers\welcome;

use app\views\welcome\Welcome as WelcomeView;

class Welcome
{
    public function execute(): void
    {
        (new WelcomeView())->show();
    }
}
