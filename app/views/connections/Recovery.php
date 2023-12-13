<?php

namespace app\views\connections;

use app\views\Layout;

class Recovery
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
        <input type="email" name="email" id="email" <?php if ($email !== '') { echo 'value="' . $email . '"'; echo 'readonly'; } ?>>

        <?php if ($isEmailVerified): ?>

        <label for="password">New Password</label>
        <input type="password" name="password" id="password">

        <label for="passwordConfirm">Confirm New Password</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm">

        <?php endif; ?>

        <a href="/login">Already have an account</a>
        <a href="/signup">Create Account</a>

        <button type="submit" name="recovery">Reset Password</button>
    </form>
</main>
<?php
        (new Layout('FakeGame - Recovery', ob_get_clean()))->show();
    }
}