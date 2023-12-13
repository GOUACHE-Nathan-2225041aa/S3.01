<?php

namespace app\controllers\connections;

use app\views\connections\Recovery as RecoveryView;
use config\DataBase;
use PDO;

class Recovery
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnection();
    }

    public function execute(): void
    {
        (new RecoveryView())->show();
    }
}
