<div id="DeepFakeGUI">
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
</div>