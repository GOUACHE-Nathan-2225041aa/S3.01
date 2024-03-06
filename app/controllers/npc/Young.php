<?php

namespace app\controllers\npc;

use app\services\Localization as LocalizationService;
use app\views\npc\Young as YoungView;
use config\DataBase;
use PDO;

class Young
{

    public function __construct()
    {
    }

    public function execute(): void
    {
        $loc = (new LocalizationService())->getArray('npc');
        (new YoungView())->show($loc);
    }
}
