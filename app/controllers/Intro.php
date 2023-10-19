<?php
class IntroController
{
    public function execute(): void
    {
        (new IntroView())->show();
    }
}
