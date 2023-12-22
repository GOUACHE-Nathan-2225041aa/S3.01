<?php

namespace app\controllers;

use app\views\Home as HomeView;

class Home
{
    public function execute(): void
    {
        $_SESSION['hint'] = true;
        $characterState = [
            'young' => 'young.png',
            'adult' => 'adult.png',
            // 'adult' => 'adult_completed.png', //Exemple personnage complété
            'old' => 'old.png',
        ];
        (new HomeView())->show($characterState);
    }

}
