<?php

namespace app\controllers\api;

use app\models\games\Games as GamesModel;
use app\services\Localization;
use config\DataBase;
use PDO;

class Dialogues
{
    private PDO $GamePDO;

    public function __construct()
    {
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        header('Content-Type: application/json');
        $postData = json_decode(file_get_contents('php://input'), true);

        $npc = htmlspecialchars($postData['npc']) ?? null;

        if ($npc === null) {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }

        if (!isset($_SESSION[$npc]) || $_SESSION[$npc] !== 'end') {
            $npcToGameTypeMap = [
                'young' => 'deep-fake',
                'old' => 'article',
                'adult' => 'audio',
            ];

//            $firstGameSlug = null;
//            if (isset($npcToGameTypeMap[$npc])) {
//                $firstGameSlug = (new GamesModel($this->GamePDO))->getFirstGameSlugByType($npcToGameTypeMap[$npc]);
//            }

//            $firstGameSlug = (new GamesModel($this->GamePDO))->getFirstRandomGameSlugByType($npcToGameTypeMap[$npc]);

            $firstGameSlug = '';
            $reset = false;

            $currentGameType = $npcToGameTypeMap[$npc];

            if (isset($_SESSION['progress'][$currentGameType]) && $_SESSION['progress'][$currentGameType]['gamesDone'] === 5) {
                $reset = true;
            }

            if (!isset($_SESSION['games'][$currentGameType]) || $reset) {
                $games = (new GamesModel($this->GamePDO))->getRandomGames(5, $currentGameType);
                $_SESSION['games'][$currentGameType] = [];
                $_SESSION['progress'] = [
                    $currentGameType => [
                        'gamesDone' => 0,
                        'totalPoints' => 0,
                    ],
                ];

                foreach ($games as $game) {
                    $_SESSION['games'][$currentGameType][] = [
                        'slug' => $game['slug'],
                        'points' => 0,
                        'done' => false,
                        'hint' => false,
                    ];
                }

                $_SESSION['checkpoints'][$currentGameType] = [
                    'index' => 0,
                ];

                $_SESSION['current_game'] = [
                    'index' => 0,
                    'type' => $currentGameType,
                ];
                $firstGameSlug = $_SESSION['games'][$currentGameType][0]['slug'];
            } else {
                $checkpoint = $_SESSION['checkpoints'][$currentGameType]['index'];

                $_SESSION['current_game'] = [
                    'index' => $checkpoint,
                    'type' => $currentGameType,
                ];

                $firstGameSlug = $_SESSION['games'][$currentGameType][$checkpoint]['slug'];
            }

            $data = [
                'dialogues' => [
                    (new Localization())->getArray('dialogues', [$npc, 'question']),
                    (new Localization())->getArray('dialogues', [$npc, 'answer']),
                ],
                'game' => $firstGameSlug,
            ];
            echo json_encode($data);
            exit();
        }

        $data = [
            'dialogues' => [
                (new Localization())->getArray('dialogues', [$npc, 'end']),
            ],
        ];
        unset($_SESSION[$npc]);
        echo json_encode($data);
    }
}
