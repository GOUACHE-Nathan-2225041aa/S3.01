<?php

namespace app\controllers\home;

use app\services\Localization as LocalizationService;
use app\services\ProgressionService;
use app\views\home\Home as HomeView;

class Home
{
    public function execute(): void
    {
        $this->refreshProgress();

        $loc = (new LocalizationService())->getArray('npc');
        (new HomeView())->show($loc);
    }

    private function refreshProgress(): void
    {
        ProgressionService::getInstance()->refreshProgression();
    }
}
