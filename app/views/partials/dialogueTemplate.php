<a id="bas" href="<?= $next_page ?>" style="text-decoration: none">

        <div id="character">
            <section id="bulle_image">
                <img id="head" src="/assets/images/characters/<?= $dataSpeaker['character_type'] ?>/<?= $dataSpeaker['character_head'] ?>.png" alt="Head of the talking character">
            </section>
            <section id="bulle_nom">
                <h1> <?= $dataSpeaker['character_name'] ?> </h1>
            </section>
        </div>

        <?php if ($dataListener !== []) { ?>
        <div id="character-full-body">
            <img id="listener" src="/assets/images/characters/<?= $dataListener['character_type'] ?>/<?= $dataListener['character_type'] ?>.png" alt="Character we talking to">
        </div>
        <?php } ?>

        <section id="bulle_texte">
            <p>
                <?= $dataSpeaker['text'] ?>
            </p>
            <img id="nextDialogue" src="/assets/images/divers/next_dialogue.gif">
        </section>

</a>