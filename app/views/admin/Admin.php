<?php

namespace app\views\admin;

use app\views\Layout;

class Admin
{
    public function show($user): void
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
        <h1>Game: Deep Fake</h1>
        <form method="POST" action="">
            <input type="hidden" name="game_type" value="deep-fake">

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="image">Image</label>
            <input type="file" name="image" id="image" required>

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

            <button type="submit" name="create-game">Create</button>
        </form>
    </div>
</main>
<?php
        (new Layout('FakeGame - Admin', ob_get_clean()))->show();
    }
}
