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
    <h1>Forgot Password ?</h1>
    <form method="POST" action="" id="test">
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

        <label for="passwordConfirmation">Confirm New Password</label>
        <input type="password" name="passwordConfirmation" id="passwordConfirmation">

        <?php endif; ?>
        <button type="submit" name="<?= $isEmailVerified ? 'recovery' : 'recovery_email_verification'; ?>">Reset Password</button>

        <div id="div-a">
            <a href="/login">Already have an account</a>
            <a href="/signup">Create Account</a>
        </div>
    </form>
</main>
<?php
        (new Layout('FakeGame - Recovery', ob_get_clean(), 'Recovery'))->show();
    }
}
