<?php

namespace config;

use PDO;

class DataBase
{
    private static ?PDO $accountConnection = null;
    private static ?PDO $gameConnection = null;

    public static function getConnectionAccount(): PDO
    {
        if (self::$accountConnection === null) {
            $config = parse_ini_file('db.ini');
            if ($config === false) {
                die("Error loading configuration file.");
            }
            self::$accountConnection = new PDO($config['dsn_account'], $config['username'], $config['password']);
        }
        return self::$accountConnection;
    }

    public static function getConnectionGame(): PDO
    {
        if (self::$gameConnection === null) {
            $config = parse_ini_file('db.ini');
            if ($config === false) {
                die("Error loading configuration file.");
            }
            self::$gameConnection = new PDO($config['dsn_game'], $config['username'], $config['password']);
        }
        return self::$gameConnection;
    }
}
