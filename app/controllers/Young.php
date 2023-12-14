<?php

namespace app\controllers;

use app\models\Deepfake as DeepfakeModel;
use app\views\Young as YoungView;

class Young
{
    public function execute(): void
    {
        if (empty($_SESSION['DeepFakeTab'])){
            // On créé l'array des DeepFake
            $DeepFakeTab = array();

            // Je créé ici les DeepFake
            // A remplacer lorsque la BDD contenant les DeepFake sera opérationnelle
            $D1 = new DeepfakeModel('trumpQuiCourt', 'https://ichef.bbci.co.uk/news/640/cpsprodpb/582D/production/_129137522_faketrump1.png', false, 1);
            $D2 = new DeepfakeModel('dojaEtTomHolland', 'https://www.virginiebonnet.com/wp-content/plugins/widgetkit/cache/gallery/528/image2-dc3d866a26.jpg', false, 2);
            $D3 = new DeepfakeModel('pigeonAvecFeuille', 'https://soreca-bordeaux.com/images/yootheme/widgetkit/gallery/image3.jpg', true, 3);

            // On ajoute les DeepFake dans le tableau
            array_push($DeepFakeTab, $D1, $D2, $D3);

            // On met le tableau dans la SESSION
            $_SESSION['DeepFakeTab'] = $DeepFakeTab;
        }
        //  Importer les deepFake
        //  Les mettre dans une classe
        //  Faire un array des deepFake
        error_log($_SESSION['DeepFakeTab'][0]->getNom());
        (new YoungView())->show($_SESSION['DeepFakeTab'][0]);
    }
}
