<?php

namespace app\controllers\npc;

use app\services\Localization as LocalizationService;
use app\views\npc\Old as OldView;
use config\DataBase;
use PDO;

class Old
{
    private PDO $GamePDO; // TODO - remove if not used

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        $loc = (new LocalizationService())->getArray('npc');
        (new OldView())->show($loc);
    }
}
