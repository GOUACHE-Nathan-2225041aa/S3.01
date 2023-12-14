<?php

namespace app\views\connections;

use app\views\Layout;

class Signup
{
    public function show(bool $isEmailVerified = false, string $email = ''): void
    {
        ob_start();
?>
<main>
    <form method="POST" action="">
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="errorMessage">
                <?= $_SESSION['errorMessage'] ?>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" <?php if ($email !== '') { echo 'value="' . $email . '"'; echo ' readonly'; } ?>>

        <?php if ($isEmailVerified): ?>

        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <label for="passwordConfirmation">Confirm Password</label>
        <input type="password" name="passwordConfirmation" id="passwordConfirmation">

        <?php endif; ?>

        <a href="/login">Already have an account</a>

        <button type="submit" name="<?= $isEmailVerified ? 'signup' : 'email_verification'; ?>">Signup</button>
    </form>
</main>
<?php
        (new Layout('FakeGame - Signup', ob_get_clean()))->show();
    }
}
