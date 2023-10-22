<?php

namespace config;

use PDO;

class DataBase
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $config = parse_ini_file('db.ini');
            if ($config === false) {
                die("Error loading configuration file.");
            }
            self::$connection = new PDO($config['dsn'], $config['username'], $config['password']);
        }
        return self::$connection;
    }
}
