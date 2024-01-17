<?php

namespace app\views\connections;

use app\views\layouts\Layout;

class Login
{
    public function show($loc): void
    {
        ob_start();
?>
<main>
    <form class="login-form" method="POST" action="">
        <div class="form-item flex-center">
            <h1 class="title"><?= $loc['login'] ?></h1>
        </div>
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="form-item errorMessage">
                <?= $_SESSION['errorMessage'] ?>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>

        <div class="form-item">
            <label for="username"><?= $loc['username'] ?></label>
            <input type="text" name="username" id="username">
        </div>

        <div class="form-item">
            <label for="password"><?= $loc['password'] ?></label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-item flex-center">
            <button class="btn btn-primary" type="submit" name="login"><?= $loc['login'] ?></button>
        </div>
        <div class="form-item links flex-center">
            <a href="/signup"><?= $loc['createAccount'] ?></a>
            <a href="/recovery"><?= $loc['forgotPassword'] ?></a>
        </div>
    </form>
</main>
<?php
        (new Layout('FakeGame - Login', ob_get_clean(), 'connection'))->show();
    }
}
