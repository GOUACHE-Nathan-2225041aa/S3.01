<?php

namespace app\views\partials;

class Dialogue
{
    public function getDialogueTemplate(): string
    {
        ob_start();
?>
<div id="dialogue">
    <div class="speaker">
        <div class="head">
            <img id="head" src="" alt="">
        </div>
        <div class="name">
            <h1 id="name"></h1>
        </div>
    </div>
    <div class="dialogue-text">
        <p id="dialogue-text"></p>
    </div>
    <div>
        <img id="click_me" src="/assets/images/divers/Click_me.png">
    </div>
</div>
<?php
        return ob_get_clean();
    }
}
?>
