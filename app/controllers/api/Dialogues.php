<?php

namespace app\controllers\api;

use app\models\games\DeepFake as DeepFakeModel;
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

        $data = [
            'dialogues' => [
                (new Localization())->getArray('dialogues', [$npc, 'question']),
                (new Localization())->getArray('dialogues', [$npc, 'answer']),
            ],
            'game' => (new DeepFakeModel($this->GamePDO))->getFirstGame('deep-fake', $_SESSION['language'])['slug'],
        ];

        echo json_encode($data);
    }
}
