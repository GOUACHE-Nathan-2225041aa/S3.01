<?php

namespace app\controllers\npc;

use app\views\npc\Young as YoungView;
use config\DataBase;
use PDO;

class Young
{
    private PDO $GamePDO; // TODO - remove if not used

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        (new YoungView())->show();
    }
}
