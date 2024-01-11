<?php

namespace app\views\admin;

use app\views\layouts\Layout;

class Admin
{
    public function show($user): void // TODO - maybe refactor the deep fake and article game creation forms to be one single form
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
    <div>
        <h1>Profile</h1>
        <ul>
            <li>Status: <?= $user['admin'] ? 'Admin' : 'User' ?></li>
            <li>UUID: <?= $user['id'] ?></li>
            <li>Username: <?= $user['username'] ?></li>
            <li>Email: <?= $user['email'] ?></li>
            <li>IP: <?= $user['ip'] ?></li>
        </ul>
    </div>
    <div>
        <a href="/admin/localization">Localization</a>
    </div>
    <div>
        <h1>Game: Deep Fake</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="game_type" value="deep-fake">

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <label for="answer">Answer</label>
            <select name="answer" id="answer" required>
                <option disabled selected>Select the answer</option>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>

            <label for="hint">Hint</label>
            <textarea name="hint" id="hint" cols="30" rows="10"></textarea>

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>

            <label for="source">Source</label>
            <input type="text" name="source" id="source">

            <label for="language">Language</label>
            <select name="language" id="language" required>
                <option disabled selected>Select the language</option>
                <option value="fr">French</option>
                <option value="en">English</option>
            </select>

            <button type="submit" name="create-game">Create</button>
        </form>
    </div>
    <div>
        <h1>Game: Article</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="game_type" value="article">

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <label for="answer">Answer</label>
            <select name="answer" id="answer" required>
                <option disabled selected>Select the answer</option>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>

            <label for="hint">Hint</label>
            <textarea name="hint" id="hint" cols="30" rows="10"></textarea>

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>

            <label for="source">Source</label>
            <input type="text" name="source" id="source">

            <label for="language">Language</label>
            <select name="language" id="language" required>
                <option disabled selected>Select the language</option>
                <option value="fr">French</option>
                <option value="en">English</option>
            </select>

            <button type="submit" name="create-game">Create</button>
        </form>
    </div>
    <div>
        <h1>Game: Audio</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="game_type" value="audio">

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <label for="audio">Audio</label>
            <input type="file" name="audio" id="audio" accept="audio/*" required>

            <label for="answer">Answer</label>
            <select name="answer" id="answer" required>
                <option disabled selected>Select the answer</option>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>

            <label for="hint">Hint</label>
            <textarea name="hint" id="hint" cols="30" rows="10"></textarea>

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>

            <label for="source">Source</label>
            <input type="text" name="source" id="source">

            <label for="language">Language</label>
            <select name="language" id="language" required>
                <option disabled selected>Select the language</option>
                <option value="fr">French</option>
                <option value="en">English</option>
            </select>

            <button type="submit" name="create-game">Create</button>
        </form>
    </div>
</main>
<?php
        (new Layout('FakeGame - Admin', ob_get_clean()))->show();
    }
}
