<?php

namespace app\views;

class YoungView
{
    public function show($imgUrl): void
    {
        ob_start();
?>
<div>
    WIP
</div>
<?php
include('DeepFakeGUI.php');
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
?>
