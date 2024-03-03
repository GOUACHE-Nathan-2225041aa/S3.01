<?php

namespace app\controllers\intro;

use app\views\intro\Intro as IntroView;

class Intro
{
    public function execute(): void
    {
        (new IntroView())->show();
    }

}
