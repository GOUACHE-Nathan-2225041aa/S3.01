<?php

namespace config;

use Exception;

class EmailConfig
{
    private static ?EmailConfig $instance = null;
    private array $config;

    private function __construct()
    {
        try {
            $this->init();
        } catch (Exception $e) {
            throw new Exception('EmailConfig init failed: ' . $e->getMessage());
        }
    }

    public static function getInstance(): EmailConfig
    {
        if (self::$instance === null) {
            self::$instance = new EmailConfig();
        }

        return self::$instance;
    }

    private function init(): void
    {
        $this->config = parse_ini_file('email.ini');
        if ($this->config === false) {
            throw new Exception("Error loading configuration file.");
        }
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
