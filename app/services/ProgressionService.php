<?php

namespace app\services;

class ProgressionService
{
    private static ?ProgressionService $instance = null;

    public function __construct()
    {
    }

    public static function getInstance(): ProgressionService
    {
        if (self::$instance === null) {
            self::$instance = new ProgressionService();
        }

        return self::$instance;
    }

    public function refreshProgression(): void
    {
        if (isset($_SESSION['games']['deep-fake']) !== null) {
            $_SESSION['progress']['deep-fake']['gamesDone'] = 0;
            $_SESSION['progress']['deep-fake']['totalPoints'] = 0;
            foreach ($_SESSION['games']['deep-fake'] as $game) {
                if ($game['done']) $_SESSION['progress']['deep-fake']['gamesDone'] += 1;
                $_SESSION['progress']['deep-fake']['totalPoints'] += $game['points'];
            }
        }
        if (isset($_SESSION['games']['audio']) !== null) {
            $_SESSION['progress']['audio']['gamesDone'] = 0;
            $_SESSION['progress']['audio']['totalPoints'] = 0;
            foreach ($_SESSION['games']['audio'] as $game) {
                if ($game['done']) $_SESSION['progress']['audio']['gamesDone'] += 1;
                $_SESSION['progress']['audio']['totalPoints'] += $game['points'];
            }
        }
        if (isset($_SESSION['games']['article']) !== null) {
            $_SESSION['progress']['article']['gamesDone'] = 0;
            $_SESSION['progress']['article']['totalPoints'] = 0;
            foreach ($_SESSION['games']['article'] as $game) {
                if ($game['done']) $_SESSION['progress']['article']['gamesDone'] += 1;
                $_SESSION['progress']['article']['totalPoints'] += $game['points'];
            }

        }
    }

    public function resetProgression($gameType): void
    {
        if ($gameType === 'deep-fake' && isset($_SESSION['games']['deep-fake']) !== null) {
            $_SESSION['progress']['deep-fake']['gamesDone'] = 0;
            $_SESSION['progress']['deep-fake']['totalPoints'] = 0;
        }
        if ($gameType === 'audio' && isset($_SESSION['games']['audio']) !== null) {
            $_SESSION['progress']['audio']['gamesDone'] = 0;
            $_SESSION['progress']['audio']['totalPoints'] = 0;
        }
        if ($gameType === 'article' && isset($_SESSION['games']['article']) !== null) {
            $_SESSION['progress']['article']['gamesDone'] = 0;
            $_SESSION['progress']['article']['totalPoints'] = 0;
        }
    }
}
