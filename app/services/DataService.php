<?php

namespace app\services;

class DataService
{
    public static function mergeGameLocals(array $gameLocals): array
    {
        $gameData = [];
        foreach ($gameLocals as $gameLocal) {
            $gameData[$gameLocal['game_id']]['game_id'] = $gameLocal['game_id'];
            $gameData[$gameLocal['game_id']][$gameLocal['field'] . '-' . $gameLocal['language']] = htmlspecialchars($gameLocal['text']);
        }
        return $gameData;
    }
}
