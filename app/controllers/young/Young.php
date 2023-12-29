<?php

namespace app\controllers\young;

use app\views\young\Young as YoungView;
use config\DataBase;
use PDO;

class Young
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        (new YoungView())->show();
    }
}
