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

            $firstGameSlug = null;
            if (isset($npcToGameTypeMap[$npc])) {
                $firstGameSlug = (new GamesModel($this->GamePDO))->getFirstGameSlugByType($npcToGameTypeMap[$npc]);
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
