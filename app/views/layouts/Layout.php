<?php

namespace app\views\layouts;

use app\views\partials\Header as HeaderView;

class Layout // TODO - add scripts there and remove them from the views
{
    public function __construct(private string $title, private string $content, private string $stylesheet = '') {}
    public function show(): void
    {
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="/assets/stylesheets/main.css">
    <link rel="stylesheet" href="/assets/stylesheets/interaction.css">
    <?php if ($this->stylesheet !== '') { ?>
        <link rel="stylesheet" href="/assets/stylesheets/<?= $this->stylesheet ?>.css">
    <?php } ?>
</head>
<body>
<?= (new HeaderView())->getHeader(); ?>
<?= $this->content ?>
</body>
</html>
<?php
    }
}
?>