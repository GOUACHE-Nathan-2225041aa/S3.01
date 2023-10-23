<?php
namespace app\controllers;

use app\models\DeepfakeModel;
use app\views\YoungView;

class YoungController
{
    public function execute(): void
    {
        // On créé l'array des DeepFake
        $DeepFakeTab = [];

        // Je créé ici les DeepFake
        // A remplacer lorsque la BDD contenant les DeepFake sera opérationnelle
        $D1 = new DeepfakeModel('trumpQuiCourt', 'https://ichef.bbci.co.uk/news/640/cpsprodpb/582D/production/_129137522_faketrump1.png', false, 1);
        $D2 = new DeepfakeModel('dojaEtTomHolland', 'https://media.canva.com/1/image-resize/1/620_372_100_PNG_F/czM6Ly9tZWRpYS1wcml2YXRlLmNhbnZhLmNvbS9IU0NvVS9NQUZ4aGxIU0NvVS8xL3AucG5n?osig=AAAAAAAAAAAAAAAAAAAAAIUL3YOOiIVxzLB8HZDH-S8Fr7FHHXQ7TThdWqGb7Iej&exp=1698080110&x-canva-quality=screen&csig=AAAAAAAAAAAAAAAAAAAAAAUqAFuieRf0x5WRF8cFfAWmanAfpEuvAe0q6CAQWmVv', false, 2);
        $D3 = new DeepfakeModel('pigeonAvecFeuille', 'https://media.canva.com/1/image-resize/1/800_450_100_PNG_F/czM6Ly9tZWRpYS1wcml2YXRlLmNhbnZhLmNvbS9CXzlZWS9NQUZ4aG1CXzlZWS8xL3AucG5n?osig=AAAAAAAAAAAAAAAAAAAAAO5yUph1LoPfG6V1k_v8hgO4-JNpXd-lhjH8AR270ngo&exp=1698081436&x-canva-quality=screen&csig=AAAAAAAAAAAAAAAAAAAAAIz-EZzP9zonDmdrexRs2hFt2ZJLeO_AyhEujDOJ9lx-', true, 3);

        // On ajoute les DeepFake dans le tableau
        array_push($DeepFakeTab, $D1, $D2, $D3);

        // On met le tableau dans la SESSION
        $_SESSION['DeepFakeTab'] = $DeepFakeTab;

        //  Importer les deepFake
        //  Les mettre dans une classe
        //  Faire un array des deepFake
        (new YoungView())->show($D1);
    }
}
