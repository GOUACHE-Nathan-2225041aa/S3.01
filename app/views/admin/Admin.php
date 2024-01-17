<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Admin
{
    public function show($loc, $user): void // TODO - maybe refactor the deep fake and article game creation forms to be one single form
    {
        ob_start();
?>
<main>
    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="errorMessage">
            <?= $_SESSION['errorMessage'] ?>
        </div>
        <?php unset($_SESSION['errorMessage']); ?>
    <?php endif; ?>
    <div class="profile">
        <h1><?= $loc['profile'] ?></h1>
        <ul>
            <li><?= $loc['status'] ?>: <?= $user['admin'] ? 'Admin' : 'User' ?></li>
            <li>UUID: <?= $user['id'] ?></li>
            <li><?= $loc['username'] ?>: <?= $user['username'] ?></li>
            <li><?= $loc['email'] ?>: <?= $user['email'] ?></li>
        </ul>
    </div>
    <div class="links">
        <a href="/admin/localization"><?= $loc['localization'] ?></a>
        <a href="/admin/games"><?= $loc['games'] ?></a>
    </div>
    <div class="game-form">
        <h1 class="title"><?= $loc['game'] ?>: Deep Fake</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="game_type" value="deep-fake">

            <div class="form-item">
                <label for="title"><?= $loc['title'] ?></label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-item">
                <label for="image"><?= $loc['image'] ?></label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <div class="form-item">
                <select name="answer" id="answer" required>
                    <option disabled selected><?= $loc['selectAnswer'] ?></option>
                    <option value="1"><?= $loc['true'] ?></option>
                    <option value="0"><?= $loc['false'] ?></option>
                </select>
            </div>
            <label for="answer"><?= $loc['answer'] ?></label>

            <div class="form-item">
                <label for="hint"><?= $loc['hint'] ?></label>
                <textarea name="hint" id="hint" cols="30" rows="10"></textarea>
            </div>

            <div class="form-item">
                <label for="description"><?= $loc['description'] ?></label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>

            <div class="form-item">
                <label for="source"><?= $loc['source'] ?></label>
                <input type="text" name="source" id="source">
            </div>

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
    </div>
    <div class="game-form">
        <h1 class="title"><?= $loc['game'] ?>: Article</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="game_type" value="article">

            <div class="form-item">
                <label for="title"><?= $loc['title'] ?></label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-item">
                <label for="image"><?= $loc['image'] ?></label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <div class="form-item">
                <label for="answer"><?= $loc['answer'] ?></label>
                <select name="answer" id="answer" required>
                    <option disabled selected><?= $loc['selectAnswer'] ?></option>
                    <option value="1"><?= $loc['true'] ?></option>
                    <option value="0"><?= $loc['false'] ?></option>
                </select>
            </div>

            <div class="form-item">
                <label for="hint"><?= $loc['hint'] ?></label>
                <textarea name="hint" id="hint" cols="30" rows="10"></textarea>
            </div>

            <div class="form-item">
                <label for="description"><?= $loc['description'] ?></label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>

            <div class="form-item">
                <label for="source"><?= $loc['source'] ?></label>
                <input type="text" name="source" id="source">
            </div>

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
    </div>
    <div class="game-form">
        <h1 class="title"><?= $loc['game'] ?>: Audio</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="game_type" value="audio">

            <div class="form-item">
                <label for="title"><?= $loc['title'] ?></label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-item">
                <label for="image"><?= $loc['image'] ?></label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <div class="form-item">
                <label for="audio"><?= $loc['audio'] ?></label>
                <input type="file" name="audio" id="audio" accept="audio/*" required>
            </div>

            <div class="form-item">
                <label for="answer"><?= $loc['answer'] ?></label>
                <select name="answer" id="answer" required>
                    <option disabled selected><?= $loc['selectAnswer'] ?></option>
                    <option value="1"><?= $loc['true'] ?></option>
                    <option value="0"><?= $loc['false'] ?></option>
                </select>
            </div>

            <div class="form-item">
                <label for="hint"><?= $loc['hint'] ?></label>
                <textarea name="hint" id="hint" cols="30" rows="10"></textarea>
            </div>

            <div class="form-item">
                <label for="description"><?= $loc['description'] ?></label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>

            <div class="form-item">
                <label for="source"><?= $loc['source'] ?></label>
                <input type="text" name="source" id="source">
            </div>

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
    </div>
</main>
<?php
        (new Layout('FakeGame - Admin', ob_get_clean(), 'admin'))->show();
    }
}
