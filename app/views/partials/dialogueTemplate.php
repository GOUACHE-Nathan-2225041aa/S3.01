<div id="bas">

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
        <img id="head" src="/assets/images/characters/<?= $dataListener['character_type'] ?>/<?= $dataListener['character_full'] ?>.png" alt="Character we talking to">
    </div>
    <?php } ?>

    <section id="bulle_texte">
        <p>
            <?= $dataSpeaker['text'] ?>
        </p>
    </section>

</div>
