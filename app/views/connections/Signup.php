<?php

namespace app\views\connections;

use app\views\layouts\Layout;

class Signup
{
    public function show($loc, bool $isEmailVerified = false, string $email = ''): void
    {
        ob_start();
?>
<main>
    <form class="login-form" method="POST" action="">
        <div class="form-item flex-center">
            <h1 class="title"><?= $loc['createAccount'] ?></h1>
        </div>
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="form-item errorMessage">
                <?= $_SESSION['errorMessage'] ?>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>

        <div class="form-item">
            <label for="email"><?= $loc['email'] ?></label>
            <input type="email" name="email" id="email" <?php if ($email !== '') { echo 'value="' . $email . '"'; echo ' readonly'; } ?>>
        </div>

        <?php if ($isEmailVerified): ?>

        <div class="form-item">
            <label for="username"><?= $loc['username'] ?></label>
            <input type="text" name="username" id="username">
        </div>

        <div class="form-item">
            <label for="password"><?= $loc['password'] ?></label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-item">
            <label for="passwordConfirmation"><?= $loc['passwordConfirmation'] ?></label>
            <input type="password" name="passwordConfirmation" id="passwordConfirmation">
        </div>

        <?php endif; ?>

        <div class="form-item flex-center">
            <button class="btn btn-primary" type="submit" name="<?= $isEmailVerified ? 'signup' : 'email_verification'; ?>"><?= $loc['signup'] ?></button>
        </div>

        <div class="form-item links flex-center">
            <a href="/login"><?= $loc['login'] ?></a>
        </div>
    </form>
</main>
<?php
        (new Layout('FakeGame - Signup', ob_get_clean(), 'connection'))->show();
    }
}
