<?php

namespace app\controllers;

use app\views\HomeView;

class HomeController
{
    public function execute(): void
    {
        $characterState = [
            'young' => 'young.png',
            'adult' => 'adult_completed.png', //Exemple personnage complété
            'old' => 'old.png',
        ];
        (new HomeView())->show($characterState);
    }

}