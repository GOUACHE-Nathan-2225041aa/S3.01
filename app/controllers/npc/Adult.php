<?php

namespace app\controllers\npc;

use app\views\npc\Adult as AdultView;
use config\DataBase;
use PDO;

class Adult
{
    private PDO $GamePDO; // TODO - remove if not used

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        (new AdultView())->show();
    }
}
