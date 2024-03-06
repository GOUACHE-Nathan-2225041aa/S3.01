<?php

namespace app\controllers\npc;

use app\services\Localization as LocalizationService;
use app\views\npc\Adult as AdultView;
use config\DataBase;
use PDO;

class Adult
{

    public function __construct()
    {
    }

    public function execute(): void
    {
        $loc = (new LocalizationService())->getArray('npc');
        (new AdultView())->show($loc);
    }
}
