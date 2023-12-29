<?php

namespace app\views\partials;

class Header
{
    public function getHeader(): string
    {
        ob_start();
?>
<header>
    <nav>
        <a href="/">Welcome</a>
        <a href="/intro">Intro</a>
        <a href="/home">Home</a>
        <a href="/login">Login</a>
        <a href="/signup">Signup</a>
        <a href="/admin">Admin</a>
        <a href="/about">About</a>
    </nav>
</header>
<?php
        return ob_get_clean();
    }
}
?>
