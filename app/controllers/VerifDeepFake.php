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
            if ($post['reponse']==='true'){
                $reponse = true;
            }
            else $reponse = false;
            if ($currentDeepFake->getIsVraiImage()===$reponse) error_log('bonne réponse');
            else error_log('mauvaise réponse');
        }
    }
}