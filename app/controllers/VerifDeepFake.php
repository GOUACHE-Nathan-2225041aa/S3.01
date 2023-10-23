<?php

namespace app\controllers;

use app\models\DeepfakeModel;

class VerifDeepFakeController
{
    public function verifierDeepFake($post){
        if(isset($post['reponse'])){
            $currentDeepFake = $_SESSION['DeepFakeTab'][0];
            echo $currentDeepFake->getIsVraiImage();
        }
    }
}