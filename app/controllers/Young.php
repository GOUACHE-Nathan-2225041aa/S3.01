<?php

namespace app\controllers;

use app\models\Deepfake as DeepfakeModel;
use app\views\Young as YoungView;

class Young
{
    public function execute(): void
    {
        if($_SESSION['picturesDone'] >= 3){
            header('Location: ./dialogue-Ey');
        }
        else if (empty($_SESSION['DeepFakeTab']) or $_SESSION['DeepFakeTab'] === array()){
            // On créé l'array des DeepFake
            $DeepFakeTab = array();

            // Je créé ici les DeepFake
            // @todo remplacer les liens des images lorsque la BDD contenant les DeepFake sera opérationnelle
            $D1 = new DeepfakeModel('Trump qui court...', 'https://ichef.bbci.co.uk/news/640/cpsprodpb/582D/production/_129137522_faketrump1.png', false);
            $D2 = new DeepfakeModel('Image numéro 2 (faux)', 'https://www.virginiebonnet.com/wp-content/plugins/widgetkit/cache/gallery/528/image2-dc3d866a26.jpg', false);
            $D3 = new DeepfakeModel('Image numéro 3 (vrai)', 'https://soreca-bordeaux.com/images/yootheme/widgetkit/gallery/image3.jpg', true);

            // On ajoute les DeepFake dans le tableau
            array_push($DeepFakeTab, $D1, $D2, $D3);

            // On met le tableau dans la SESSION
            $_SESSION['DeepFakeTab'] = $DeepFakeTab;
        }
        //  Importer les deepFake
        //  Les mettre dans une classe
        //  Faire un array des deepFake
        $currentD = $_SESSION['DeepFakeTab'][0];
        if(isset($_SESSION['VerifDeepfake']) && $_SESSION['VerifDeepfake']){
            array_shift($_SESSION['DeepFakeTab']);
        }
        (new YoungView())->show($currentD->getImageUrl(),$currentD->getNom());
    }
}
