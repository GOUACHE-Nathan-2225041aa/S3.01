<?php

namespace app\controllers\Intro;

use app\views\intro\Intro as IntroView;

class Intro // TODO - complete the class
{
    public function execute(): void
    {
        (new IntroView())->show();
    }

}
