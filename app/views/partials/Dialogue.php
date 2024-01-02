<?php

namespace app\views\partials;

class Dialogue // TODO - refactor this class (style, id names, etc.)
{
    public function getDialogueTemplate(): string
    {
        ob_start();
?>
<div id="bas" style="text-decoration: none">
    <div>
        <div id="bulle_image">
            <img id="head" src="" alt="">
        </div>
        <div id="bulle_nom">
            <h1 id="name"></h1>
        </div>
    </div>

    <div id="character-full-body" style="display: none">
        <img id="listener" src="" alt="">
    </div>

    <div id="bulle_texte">
        <p id="dialogue-text" class="text_dialogue"></p>
        <button id="btn-dialogue"><img id="nextDialogue" src="/assets/images/divers/next_dialogue.gif" alt="Next dialogue"></button>
    </div>
</div>
<?php
        return ob_get_clean();
    }
}
?>
