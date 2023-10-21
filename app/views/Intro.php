<?php
class IntroView
{
    public function show($chara, $text): void
    {
        ob_start();
?>

<div id="bas">

    <div id="character">
        <section id="bulle_image">
            <?php
                switch ($chara) {
                    case 'young':
                        echo "<img id='head' src='/assets/images/characters/young/young_head.png' alt='Head of the talking character'>";
                        break;
                    case 'adult':
                        echo "<img id='head' src='/assets/images/characters/adult/adult_head.png' alt='Head of the talking character'>";
                        break;
                    case 'old':
                        echo "<img id='head' src='/assets/images/characters/old/old_head.png' alt='Head of the talking character'>";
                        break;
                    default:
                        echo "<img id='head' src='/assets/images/characters/me_head.png' alt='Head of the talking character'>";
                        break;
                }
            ?>
        </section>
        <section id="bulle_nom">
            <h1> <?php echo $chara ?> </h1>
        </section>
    </div>

    <section id="bulle_texte">
        <p>
            <?php echo $text ?>
        </p>
    </section>

</div>

<?php
        (new Layout('FakeGame - Intro', ob_get_clean(), 'intro'))->show();
    }
}
?>
