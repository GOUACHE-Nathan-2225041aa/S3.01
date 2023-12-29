<?php

namespace app\services;

use Exception;

class Localization // TODO - add default language which must be up to date to work properly
{
    private string $lang;
    private array $config;

    public function __construct()
    {
        $configPath = __DIR__ . '/../../config/LocalizationConfig.php';
        if (!file_exists($configPath)) {
            throw new Exception("Configuration file not found: {$configPath}");
        }

        $this->config = require $configPath;

        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = $this->getPreferredLanguage();
        }

        if (!in_array($_SESSION['language'], $this->config['allowed_languages'])) {
            $_SESSION['language'] = 'en';
        }

        $this->lang = $_SESSION['language'];
    }

    private function getPreferredLanguage(): string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return 'en';
        }

        $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        return substr($languages[0], 0, 2);
    }

    public function setLanguage($lang): void
    {
        if (!in_array($lang, $this->config['allowed_languages'])) {
            return;
        }

        $_SESSION['language'] = $lang;
        $this->lang = $lang;
    }

    public function getText($file, array $keys): ?string
    {
        if (!in_array($file, $this->config['allowed_files'])) {
            error_log("File not found: $file");
            return null;
        }

        $translations = require __DIR__ . "/../../locales/$this->lang/$file.php";

        $value = $translations;
        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                error_log("Undefined array key: $key");
                return null;
            }
            $value = $value[$key];
        }

        return $value;
    }

    public function getArray($file, array $keys): ?array
    {
        if (!in_array($file, $this->config['allowed_files'])) {
            error_log("File not found: $file");
            return null;
        }

        $translations = require __DIR__ . "/../../locales/$this->lang/$file.php";

        $value = $translations;
        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                error_log("Undefined array key: $key");
                return null;
            }
            $value = $value[$key];
        }

        return $value;
    }
}
