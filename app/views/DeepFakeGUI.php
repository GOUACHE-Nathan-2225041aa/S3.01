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

    </div>

</section>