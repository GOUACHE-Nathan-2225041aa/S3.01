<?php

namespace app\controllers\admin;

use app\services\FileService;
use app\services\Localization as LocalizationService;
use app\views\admin\Admin as AdminView;
use app\models\User as UserModel;
use app\models\games\DeepFake as DeepFakeModel;
use app\models\games\Article as ArticleModel;
use app\models\games\Audio as AudioModel;
use app\models\games\Games as GamesModel;
use config\DataBase;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;
use app\services\DataService;
use app\models\games\Localization as LocalizationModel;

class Admin // TODO - refactor duplications
{
    private PDO $AccountPDO;
    private PDO $GamePDO;

    public function __construct()
    {
        $this->AccountPDO = DataBase::getConnectionAccount();
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(array $data): void
    {
        $this->userAuth();

        $params = $data['query'] ?? [];
        $gameData = null;

        if (isset($params['update']) && isset($params['type'])) {
            $gameId = htmlspecialchars($params['update']);
            $gameType = htmlspecialchars($params['type']);
            $gameData = (new GamesModel($this->GamePDO))->getGameDetailsById($gameId, $gameType);
            $gameLocals = DataService::mergeGameLocals($gameData['localization']);
            unset($gameData['localization']);
            $gameData = array_merge($gameData, $gameLocals[$gameId]);
            if (isset($gameData['image'])) $gameData['image'] = base64_encode($gameData['image']);
            if (isset($gameData['audio'])) $gameData['audio'] = base64_encode($gameData['audio']);
        }

        $loc = (new LocalizationService())->getArray('admin');
        $user = (new UserModel($this->AccountPDO))->getUserByUsername($_SESSION['username']);
        (new AdminView())->show($loc, $user, $gameData);
    }

    public function updateGame(array $data): void
    {
        $this->userAuth();

        $postData = $data['post'];
        $fileData = $data['files'];

        if (!isset($postData['game_type'])) {
            $_SESSION['errorMessage'] = 'Missing game type';
            header('Location: /admin');
            exit();
        }

        FileService::isImageValid($fileData);
        $jpegImage = FileService::convertPngToJpg($fileData);
        $gameData['image'] = $jpegImage;

        if ($postData['game_type'] === 'audio') {
            FileService::isAudioValid($fileData);
            $audio = file_get_contents($fileData['audio']['tmp_name']);
            $gameData['audio'] = $audio;
        }

        $slug = $this->generateSlug(htmlspecialchars($postData['title-en'] ?? $postData['title-fr']));

        if ($slug === null) {
            $_SESSION['errorMessage'] = 'Error while generating game url';
            header('Location: /admin');
            exit();
        }

        $gameData += [
            'id' => htmlspecialchars($postData['game_id']),
            'game_type' => htmlspecialchars($postData['game_type']),
            'source' => htmlspecialchars($postData['source']),
            'slug' => $slug,
            'answer' => (int)htmlspecialchars($postData['answer']),
            'inserter_id' => $_SESSION['id'],
        ];

        $localizationDataFr = DataService::buildLocalizationDataLang($postData, 'fr');
        $localizationDataEn = DataService::buildLocalizationDataLang($postData, 'en');

        try {
            switch ($postData['game_type']) {
                case 'deep-fake':
                    (new DeepFakeModel($this->GamePDO))->updateGame($gameData);
                    break;
                case 'article':
                    (new ArticleModel($this->GamePDO))->updateGame($gameData);
                    break;
                case 'audio':
                    (new AudioModel($this->GamePDO))->updateGame($gameData);
                    break;
                default:
                    $_SESSION['errorMessage'] = 'Invalid game type';
                    header('Location: /admin');
                    exit();
            }
            $localizationModel = new LocalizationModel($this->GamePDO);
            $localizationModel->save($localizationDataFr, $gameData['id']);
            $localizationModel->save($localizationDataEn, $gameData['id']);
            $_SESSION['errorMessage'] = 'Game updated successfully';
            header('Location: /admin');
            exit();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $_SESSION['errorMessage'] = 'Error while updating game';
            header('Location: /admin');
            exit();
        }
    }

    public function createGame(array $data): void
    {
        $postData = $data['post'];
        $fileData = $data['files'];

        $this->userAuth();

        if (!isset($postData['game_type'])) {
            $_SESSION['errorMessage'] = 'Missing game type';
            header('Location: /admin');
            exit();
        }

        switch ($postData['game_type']) {
            case 'deep-fake':
                $this->handleDeepFakeGame($postData, $fileData);
                break;
            case 'article':
                $this->handleArticleGame($postData, $fileData);
                break;
            case 'audio':
                $this->handleAudioGame($postData, $fileData);
                break;
            default:
                $_SESSION['errorMessage'] = 'Invalid game type';
                header('Location: /admin');
                exit();
        }
    }

    private function handleDeepFakeGame($postData, $fileData): void
    {
        FileService::isImageValid($fileData);

        $jpegImage = FileService::convertPngToJpg($fileData);

        $uuid = Uuid::uuid4()->toString();

        $slug = $this->generateSlug(htmlspecialchars($postData['title']));

        if ($slug === null) {
            $_SESSION['errorMessage'] = 'Error while generating game url';
            header('Location: /admin');
            exit();
        }

        $gameData = [
            'id' => $uuid,
            'game_type' => htmlspecialchars($postData['game_type']),
            'creation_date' => date('Y-m-d H:i:s'),
            'image' => $jpegImage,
            'source' => htmlspecialchars($postData['source']),
            'inserter_id' => $_SESSION['id'],
            'slug' => $slug,
            'answer' => (int)htmlspecialchars($postData['answer']),
        ];

        $localizationData = DataService::buildLocalizationData($postData);

        try {
            (new DeepFakeModel($this->GamePDO))->createGame($gameData, $localizationData);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $_SESSION['errorMessage'] = 'Error while creating game';
            header('Location: /admin');
            exit();
        }

        $_SESSION['errorMessage'] = 'Game created successfully';
        header('Location: /admin');
        exit();
    }

    private function handleArticleGame($postData, $fileData): void
    {
        FileService::isImageValid($fileData);

        $jpegImage = FileService::convertPngToJpg($fileData);

        $uuid = Uuid::uuid4()->toString();

        $slug = $this->generateSlug(htmlspecialchars($postData['title']));

        if ($slug === null) {
            $_SESSION['errorMessage'] = 'Error while generating game url';
            header('Location: /admin');
            exit();
        }

        $gameData = [
            'id' => $uuid,
            'game_type' => htmlspecialchars($postData['game_type']),
            'creation_date' => date('Y-m-d H:i:s'),
            'image' => $jpegImage,
            'source' => htmlspecialchars($postData['source']),
            'inserter_id' => $_SESSION['id'],
            'slug' => $slug,
            'answer' => (int)htmlspecialchars($postData['answer']),
        ];

        $localizationData = DataService::buildLocalizationData($postData);

        try {
            (new ArticleModel($this->GamePDO))->createGame($gameData, $localizationData);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $_SESSION['errorMessage'] = 'Error while creating game';
            header('Location: /admin');
            exit();
        }

        $_SESSION['errorMessage'] = 'Game created successfully';
        header('Location: /admin');
        exit();
    }

    private function handleAudioGame($postData, $fileData): void
    {
        FileService::isImageValid($fileData);
        FileService::isAudioValid($fileData);

        $jpegImage = FileService::convertPngToJpg($fileData);
        $audio = file_get_contents($fileData['audio']['tmp_name']);

        $uuid = Uuid::uuid4()->toString();

        $slug = $this->generateSlug(htmlspecialchars($postData['title']));

        if ($slug === null) {
            $_SESSION['errorMessage'] = 'Error while generating game url';
            header('Location: /admin');
            exit();
        }

        $gameData = [
            'id' => $uuid,
            'game_type' => htmlspecialchars($postData['game_type']),
            'creation_date' => date('Y-m-d H:i:s'),
            'image' => $jpegImage,
            'audio' => $audio,
            'source' => htmlspecialchars($postData['source']),
            'inserter_id' => $_SESSION['id'],
            'slug' => $slug,
            'answer' => (int)htmlspecialchars($postData['answer']),
        ];

        $localizationData = DataService::buildLocalizationData($postData);

        try {
            (new AudioModel($this->GamePDO))->createGame($gameData, $localizationData);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $_SESSION['errorMessage'] = 'Error while creating game';
            header('Location: /admin');
            exit();
        }

        $_SESSION['errorMessage'] = 'Game created successfully';
        header('Location: /admin');
        exit();
    }

    private function userAuth(): void
    {
        if (!isset($_SESSION['username'])) {
            $_SESSION['errorMessage'] = 'Veuillez vous connecter';
            header('Location: /login');
            exit();
        }
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            $_SESSION['errorMessage'] = 'Vous n\'avez pas les droits pour accéder à cette page';
            header('Location: /');
            exit();
        }
    }

    private function generateSlug($title): ?string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $existingGamesCount = (new GamesModel($this->GamePDO))->getCountOfGamesBySlug($slug);

        if ($existingGamesCount === null) return null;

        if ($existingGamesCount > 0) {
            $slug .= '-' . $existingGamesCount;
        }

        return $slug;
    }
}
