<section id="game_screen">

    <div id="YoungAnswer">
        <div id="DeepFakePicture">
            <img src="<?= $imgUrl ?>">
        </div>

        <div id="Answer">
            <?php
            if($reponse) {
                echo '<h1 style="color: green">Bonne réponse !</h1>';
            } else {
                echo '<h1 style="color: red">Mauvaise réponse !</h1>';
            }
            ?>
        </div>

        <button onclick="window.location.href='./young'"> Image Suivante </button>
    </div>

</section>