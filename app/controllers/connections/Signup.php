<?php

namespace app\controllers\connections;

use app\models\User as UserModel;
use app\views\connections\Signup as SignupView;
use config\DataBase;
use PDO;

class Signup
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnection();
    }

    public function execute(): void
    {
        (new SignupView())->show();
    }
}
