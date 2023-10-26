<?php

namespace app\controllers;

use app\models\Deepfake as DeepfakeModel;

class VerifDeepFake
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
            unset($_SESSION['DeepFakeTab'][0]);
            $_SESSION['DeepFakeTab'] = array_values($_SESSION['DeepFakeTab']);
            var_dump($_SESSION['DeepFakeTab']);
            if ($currentDeepFake->getIsVraiImage()===$reponse){
                error_log('bonne réponse');
            }
            else{
                error_log('mauvaise réponse');
            }
        }
    }
}