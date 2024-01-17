<?php

namespace app\controllers\api;

use app\services\Localization as LocalizationService;

class Language
{
    public function execute(): void
    {
        header('Content-Type: application/json');
        $postData = json_decode(file_get_contents('php://input'), true);

        $language = htmlspecialchars($postData['language']) ?? null;

        if ($language === null) {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }

        (new LocalizationService())->setLanguage($language);

        echo json_encode(['success' => true]);
        exit();
    }
}
