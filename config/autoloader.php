<?php

function autoloader($class): void
{
    $classPath = str_replace('\\', '/', $class);
    $classPath = str_replace(['Controller', 'Model', 'View'], '', $classPath);
    $file = '../' . $classPath . '.php';

    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('autoloader');
