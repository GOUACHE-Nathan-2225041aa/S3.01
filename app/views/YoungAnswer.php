<?php

namespace app\views;

class YoungAnswer
{
    public function show($sourceUrl, $answer, $explaination): void
    {
        ob_start();
        include('YoungAnswerTemplate.php');
        (new Layout('FakeGame - Young', ob_get_clean(), 'youngGame'))->show();
    }
}
?>
