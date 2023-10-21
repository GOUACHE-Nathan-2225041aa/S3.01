<?php
class IntroView
{
    public function show(): void
    {
        ob_start();
?>

<div id="bas">

    <section id="bulle_nom">
        <h1>Moi</h1>
    </section>

    <section id="bulle_texte">
        <h2> Texte </h2>
        <h2> Texte </h2>
        <h2> Texte </h2>
        <h2> Texte </h2>
        <h2> Texte </h2>
    </section>

</div>

<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
