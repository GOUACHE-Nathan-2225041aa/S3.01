<section id="game_screen">

    <div id="DeepFakeGUI">

        <div id="Answer">
            <?php
            $_SESSION['hint'] = true;
            if($answer) {
                echo '<h1 style="color: green">Bonne réponse !</h1>';
            } else {
                echo '<h1 style="color: red">Mauvaise réponse !</h1>';
            }
            ?>
        </div>

        <section id="Frame">
            <div id="DFP">
                <img id="ImageOnTheSide" src="<?= $sourceUrl ?>">
                <a id="Source" href="https://imgs.search.brave.com/2qAjcULfcJroIjyYIpc4YOiFM0i-adZJhliBqpXFxE0/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNDky/MjU4MzQ4L3Bob3Rv/L25hdHVyYWwtd2F0/ZXItaW4tYS1nbGFz/cy5qcGc_cz02MTJ4/NjEyJnc9MCZrPTIw/JmM9M3hmcF9PS0li/b1NnRWNjSHE4cmlC/Qzhmampfc2hFWXNt/NGJMNS1qcEo5ST0">Source</a>
            </div>
            <div id="Explications">
                <p> <?= $explaination ?> </p>
                <br>
                <p> Troll third-person tryhard non-player character The Legend of Zelda: Ocarina of Time
                    loot system PlayStation 4 emulator combo headshot.Camping/Active Camping pwned RTS
                    Star Wars: Battlefront area of effect shoulder buttons influencer marketing.
                    Action game first-party developer Ratchet & Clank spoiler multiplayer online
                    battle arena Puzzle Game
                    resolution camp Driving simulator pause Bejeweled.
                    Shovelware Final Fantasy rubber banding Sony power-Up Gears of War Baldur's Gate
                    beastiary Game Over feeding. GoldenEye 007 demo Call of Duty Hack ‘n’ Slasher.</p>
            </div>
        </section>

        <div id="Next">
            <button id="Understood" onclick="window.location.href='./young'"> J'ai tout compris !</button>
        </div>

    </div>

</section>