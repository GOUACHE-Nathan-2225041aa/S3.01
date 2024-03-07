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

    public static function buildLocalizationData(array $postData): array
    {
        $language = htmlspecialchars($postData['language']);
        return [
            [
                'field' => 'title',
                'language' => $language,
                'text' => htmlspecialchars($postData['title']),
            ],
            [
                'field' => 'hint',
                'language' => $language,
                'text' => htmlspecialchars($postData['hint']),
            ],
            [
                'field' => 'description',
                'language' => $language,
                'text' => htmlspecialchars($postData['description']),
            ],
        ];
    }

    public static function buildLocalizationDataLang(array $postData, string $lang): array
    {
        return [
            [
                'field' => 'title',
                'language' => $lang,
                'text' => htmlspecialchars($postData['title-' . $lang]),
            ],
            [
                'field' => 'hint',
                'language' => $lang,
                'text' => htmlspecialchars($postData['hint-' . $lang]),
            ],
            [
                'field' => 'description',
                'language' => $lang,
                'text' => htmlspecialchars($postData['description-' . $lang]),
            ],
        ];
    }
}
