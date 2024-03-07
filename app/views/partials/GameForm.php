<?php

namespace app\views\partials;

class GameForm
{
    public function getNewForm($loc): string
    {
        ob_start();
?>
<h1 class="title"><?= $loc['createGame'] ?></h1>
<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-item">
        <label for="game-type"><?= $loc['gameType'] ?></label>
        <select name="game_type" id="game-type" required>
            <option disabled selected><?= $loc['selectGameType'] ?></option>
            <option value="deep-fake"><?= $loc['deepFake'] ?></option>
            <option value="article"><?= $loc['article'] ?></option>
            <option value="audio"><?= $loc['audio'] ?></option>
        </select>
    </div>
    <?= $this->getFormFields($loc) ?>
    <?= $this->getLocalizationFormFields($loc) ?>
    <div class="form-item">
        <label for="language"><?= $loc['language'] ?></label>
        <select name="language" id="language" required>
            <option disabled selected><?= $loc['selectLanguage'] ?></option>
            <option value="fr"><?= $loc['fr'] ?></option>
            <option value="en"><?= $loc['en'] ?></option>
        </select>
    </div>
    <div class="form-item">
        <button class="btn btn-primary" type="submit" name="create-game"><?= $loc['create'] ?></button>
    </div>
</form>
<?php
        return ob_get_clean();
    }

    public function getEditForm($loc, $gameData): string
    {
        ob_start();
?>
<h1 class="title"><?= $loc['updateGame'] ?>: <?= $gameData['game_type'] ?></h1>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="game_type" value="<?= $gameData['game_type'] ?>">
    <input type="hidden" name="game_id" value="<?= $gameData['game_id'] ?>">
    <?= $this->getFormFields($loc, $gameData) ?>
    <div class="form-row">
        <?= $this->getLocalizationFormFields($loc, $gameData, '-fr') ?>
        <?= $this->getLocalizationFormFields($loc, $gameData, '-en') ?>
    </div>
    <div class="form-item">
        <button class="btn btn-danger" type="submit" name="update-game"><?= $loc['update'] ?></button>
    </div>
</form>
<?php
        return ob_get_clean();
    }

    private function getFormFields($loc, $gameData = null): string
    {
        ob_start();
?>
<div class="form-row">
    <div class="form-item">
        <label for="image"><?= $loc['image'] ?></label>
        <input type="file" name="image" id="image" accept="image/*">
        <label for="image" id="image-input-label"><?= $loc['chooseFile'] ?></label>
        <?php if ($gameData !== null): ?>
            <div>
                <img data-src="data:image/jpeg;base64,<?= $gameData['image'] ?>" src="" alt="">
            </div>
        <?php endif; ?>
    </div>
    <?php if ($gameData === null || $gameData['game_type'] === 'audio'): ?>
        <div class="form-item">
            <label for="audio"><?= $loc['audio'] ?></label>
            <input type="file" name="audio" id="audio" accept="audio/*">
            <label for="audio" id="audio-input-label"><?= $loc['chooseFile'] ?></label>
            <?php if ($gameData !== null): ?>
                <audio id="audio" controls onloadeddata="this.volume = 0.2">
                    <source src="data:audio/mpeg;base64,<?= $gameData['audio'] ?? '' ?>" type="audio/mpeg">
                </audio>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<div class="form-row">
    <div class="form-item">
        <label for="answer"><?= $loc['answer'] ?></label>
        <select name="answer" id="answer" required>
            <option disabled selected><?= $loc['selectAnswer'] ?></option>
            <option value="1" <?= isset($gameData['answer']) && $gameData['answer'] == '1' ? 'selected' : '' ?>><?= $loc['true'] ?></option>
            <option value="0" <?= isset($gameData['answer']) && $gameData['answer'] == '0' ? 'selected' : '' ?>><?= $loc['false'] ?></option>
        </select>
    </div>
    <div class="form-item">
        <label for="source"><?= $loc['source'] ?></label>
        <input type="text" name="source" id="source" value="<?= html_entity_decode($gameData['source'] ?? '') ?>">
    </div>
</div>
<?php
        return ob_get_clean();
    }

    private function getLocalizationFormFields($loc, $gameData = null, $lang = null): string
    {
        ob_start();
?>
<div class="form-column">
    <?php if ($lang !== null): ?>
    <h2><?= strtoupper(substr($lang, 1)) ?></h2>
    <?php endif; ?>
    <div class="form-item">
        <label for="title<?= $lang ?? '' ?>"><?= $loc['title'] ?></label>
        <input type="text" name="title<?= $lang ?? '' ?>" id="title<?= $lang ?? '' ?>" value="<?= html_entity_decode($gameData['title' . $lang] ?? '') ?>" required>
    </div>
    <div class="form-item">
        <label for="hint<?= $lang ?? '' ?>"><?= $loc['hint'] ?></label>
        <textarea name="hint<?= $lang ?? '' ?>" id="hint<?= $lang ?? '' ?>" cols="30" rows="10"><?= html_entity_decode($gameData['hint' . $lang] ?? '') ?></textarea>
    </div>
    <div class="form-item">
        <label for="description<?= $lang ?? '' ?>"><?= $loc['description'] ?></label>
        <textarea name="description<?= $lang ?? '' ?>" id="description<?= $lang ?? '' ?>" cols="30" rows="10"><?= html_entity_decode($gameData['description' . $lang] ?? '') ?></textarea>
    </div>
</div>
<?php
        return ob_get_clean();
    }
}
