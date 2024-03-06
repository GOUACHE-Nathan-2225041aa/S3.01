<?php

namespace app\controllers\npc;

use app\services\Localization as LocalizationService;
use app\views\npc\Old as OldView;
use config\DataBase;
use PDO;

class Old
{

    public function __construct()
    {
    }

    public function execute(): void
    {
        $loc = (new LocalizationService())->getArray('npc');
        (new OldView())->show($loc);
    }
}
