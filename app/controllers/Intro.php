<?php
class IntroController
{
    public function execute(): void
    {
        $text = "Hey, <br> j’ai pris l’habitude de lire le journal dans le parc après mon boulot. <br> Cependant, j’ai récemment remarqué que de plus en plus d’articles sonnaient “faux” ou peu fiables. <br> Pourrais tu m’aider à les trouver ?";
        (new IntroView())->show('adult', $text);
    }

}
