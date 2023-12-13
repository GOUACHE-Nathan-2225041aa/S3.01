<?php

namespace app\controllers\connections;

use app\models\User as UserModel;
use app\views\connections\Login as LoginView;
use config\DataBase;
use PDO;

class Login
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnection();
    }

    public function execute(): void
    {
        (new LoginView())->show();
    }
}
