<?php

namespace app\views\connections;

use app\views\Layout;

class Login
{
    public function show(): void
    {
        ob_start();
?>
<main>
    <form method="POST" action="" id="Login-Form">
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="errorMessage">
                <?= $_SESSION['errorMessage'] ?>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>

        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button type="submit" name="login">Login</button>

        <a href="/signup">Create Account</a>
        <a href="/recovery">Forgot Password</a>
    </form>
</main>
<?php
        (new Layout('FakeGame - Login', ob_get_clean(), 'Login'))->show();
    }
}
