<?php

namespace app\views\layouts;

use app\views\partials\Header as HeaderView;

class Layout
{
    public function __construct(private string $title, private string $content, private string $stylesheet = '',
                                private array $scripts = []) {}
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
    <link rel="icon" type="image/x-icon" href="/assets/images/divers/Logo_MarsActu_SeriousGame.png">
    <link rel="stylesheet" href="/assets/stylesheets/main.css">
    <?php if ($this->stylesheet !== '') { ?>
    <link rel="stylesheet" href="/assets/stylesheets/<?= $this->stylesheet ?>.css">
    <?php } ?>
    <script defer src="/assets/scripts/lang.js"></script>
    <script defer src="/assets/scripts/progress.js"></script>
    <?php foreach ($this->scripts as $script) { ?>
    <script defer src="/assets/scripts/<?= $script ?>.js"></script>
    <?php } ?>
    <script>0</script>
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
