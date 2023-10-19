<?php
session_start();

include_once '../config/autoloader.php';

try {
    if (isset($_SERVER['REQUEST_URI'])) {
        $route = $_SERVER['REQUEST_URI'];

        switch ($route) {
            case '/':
                (new IntroController())->execute();
                break;
            default:
                error_log('404 Not Found. Not implemented yet');
                break;
        }
    }
} catch (Exception) {

}
