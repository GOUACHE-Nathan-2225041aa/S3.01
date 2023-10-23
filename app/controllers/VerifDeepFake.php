<?php

namespace app\controllers;

use app\models\DeepfakeModel;

class VerifDeepFakeController
{
    public function verifierDeepFake($post): void
    {
        if(isset($post['reponse']))
        {
            $currentDeepFake = $_SESSION['DeepFakeTab'][0];
            // test
            if ($currentDeepFake->getIsVraiImage()) error_log('true');
            if (!$currentDeepFake->getIsVraiImage()) error_log('false');
        }
    }
}