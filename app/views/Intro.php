<?php
class IntroView
{
    public function show(): void
    {
        ob_start();
?>
<div>
    WIP
</div>
<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
