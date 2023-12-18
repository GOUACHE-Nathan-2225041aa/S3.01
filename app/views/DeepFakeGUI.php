<section id="game_screen">

    <div id="DeepFakeGUI">

        <section id="Titre">
            <h1><?= $titre ?></h1>
        </section>

        <section id="Contenu">
            <div id="DeepFakePicture">
                <img src="<?= $imgUrl ?>">
            </div>
            <div id="BoutonsChoix">
                <form method="post" action="">
                    <button type="submit" name="reponse" value="true" id="BoutonReel">Réel</button>
                    <br>
                    <label>OU</label>
                    <br>
                    <button type="submit" name="reponse" value="false" id="BoutonFake">Fake</button>
                </form>
            </div>
        </section>

        <div id="Hint">
            <button id="Understood" onclick=""> J'ai besoin d'un indice... </button>
        </div>
        <?php
            if($_SESSION["picturesDone"] == 0) {
                $explicationsDuJeu = "Aidons le à dicerner les vraies images des fausses. Dans ce jeu, tu dois déterminer si l'image à l'écran est une vraie photo, où si elle à été généré par une intelligence artificielle.";
                # (new DialogueController())->execute('me', 'Moi', $explicationsDuJeu, '','/young');
                # => Adapter dialogueTemplate pour afficher un dialogue par dessus une page
            }
            if($_SESSION["hint"]) {
                $indice = "Si tu regarde bien à gauche de l'image, on voit un bandeau rouge avec écrit FAKE... à par ça l'image est bien faite";
                # (new DialogueController())->execute('me', 'Moi', $indice, '','/young');
                # => Adapter dialogueTemplate pour afficher un dialogue par dessus une page
            }
        ?>
    </div>

</section>