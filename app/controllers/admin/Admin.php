<?php

namespace app\controllers\admin;

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

class Admin // TODO - refactor duplications
{
    private PDO $AccountPDO;
    private PDO $GamePDO;

    public function __construct()
    {
        $this->AccountPDO = DataBase::getConnectionAccount();
        $this->GamePDO = DataBase::getConnectionGame();
    }

    public function execute(): void
    {
        // TODO - refactor this
        $this->userAuth();
        $loc = (new LocalizationService())->getArray('admin');
        $user = (new UserModel($this->AccountPDO))->getUserByUsername($_SESSION['username']);
        (new AdminView())->show($loc, $user);
    }

    public function createGame($postData, $fileData): void
    {
        $this->userAuth();

        if (!isset($postData['game_type'])) {
            $_SESSION['errorMessage'] = 'Missing game type';
            header('Location: /admin');
            exit();
        }

        if ($postData['game_type'] === 'deep-fake') {
            $this->gameDeepFake($postData, $fileData);
        }

        if ($postData['game_type'] === 'article') {
            $this->gameArticle($postData, $fileData);
        }

        if ($postData['game_type'] === 'audio') {
            $this->gameAudio($postData, $fileData);
        }
    }

    private function gameDeepFake($postData, $fileData): void
    {
        if (!is_uploaded_file($fileData['image']['tmp_name'])) {
            $_SESSION['errorMessage'] = 'Missing image';
            header('Location: /admin');
            exit();
        }

        if (!in_array($fileData['image']['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $_SESSION['errorMessage'] = 'Wrong image type';
            header('Location: /admin');
            exit();
        }

        if ($fileData['image']['size'] > 5 * 1024 * 1024) {
            $_SESSION['errorMessage'] = 'Image too big';
            header('Location: /admin');
            exit();
        }

        $jpegImage = null;

        if ($fileData['image']['type'] == 'image/png') {
            $sourceImage = imagecreatefrompng($fileData['image']['tmp_name']);
            ob_start();
            imagejpeg($sourceImage, null, 75);
            $jpegImage = ob_get_clean();
            imagedestroy($sourceImage);
        } else {
            $jpegImage = file_get_contents($fileData['image']['tmp_name']);
        }

        $uuid = Uuid::uuid4()->toString();

        $slug = $this->generateSlug(htmlspecialchars($postData['title']), htmlspecialchars($postData['game_type']));

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

        $language = htmlspecialchars($postData['language']);

        $localizationData = [
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

    private function gameArticle($postData, $fileData): void
    {
        if (!is_uploaded_file($fileData['image']['tmp_name'])) {
            $_SESSION['errorMessage'] = 'Missing image';
            header('Location: /admin');
            exit();
        }

        if (!in_array($fileData['image']['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $_SESSION['errorMessage'] = 'Wrong image type';
            header('Location: /admin');
            exit();
        }

        if ($fileData['image']['size'] > 5 * 1024 * 1024) {
            $_SESSION['errorMessage'] = 'Image too big';
            header('Location: /admin');
            exit();
        }

        $jpegImage = null;

        if ($fileData['image']['type'] == 'image/png') {
            $sourceImage = imagecreatefrompng($fileData['image']['tmp_name']);
            ob_start();
            imagejpeg($sourceImage, null, 75);
            $jpegImage = ob_get_clean();
            imagedestroy($sourceImage);
        } else {
            $jpegImage = file_get_contents($fileData['image']['tmp_name']);
        }

        $uuid = Uuid::uuid4()->toString();

        $slug = $this->generateSlug(htmlspecialchars($postData['title']), htmlspecialchars($postData['game_type']));

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

        $language = htmlspecialchars($postData['language']);

        $localizationData = [
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

    private function gameAudio($postData, $fileData): void
    {
        if (!is_uploaded_file($fileData['image']['tmp_name'])) {
            $_SESSION['errorMessage'] = 'Missing image';
            header('Location: /admin');
            exit();
        }

        if (!is_uploaded_file($fileData['audio']['tmp_name'])) {
            $_SESSION['errorMessage'] = 'Missing audio';
            header('Location: /admin');
            exit();
        }

        if (!in_array($fileData['image']['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $_SESSION['errorMessage'] = 'Wrong image type';
            header('Location: /admin');
            exit();
        }

        if ($fileData['audio']['type'] != 'audio/mpeg') {
            $_SESSION['errorMessage'] = 'Wrong audio type';
            header('Location: /admin');
            exit();
        }

        if ($fileData['image']['size'] > 5 * 1024 * 1024) {
            $_SESSION['errorMessage'] = 'Image too big';
            header('Location: /admin');
            exit();
        }

        if ($fileData['audio']['size'] > 5 * 1024 * 1024) {
            $_SESSION['errorMessage'] = 'Audio too big';
            header('Location: /admin');
            exit();
        }

        $jpegImage = null;
        $audio = file_get_contents($fileData['audio']['tmp_name']);

        if ($fileData['image']['type'] == 'image/png') {
            $sourceImage = imagecreatefrompng($fileData['image']['tmp_name']);
            ob_start();
            imagejpeg($sourceImage, null, 75);
            $jpegImage = ob_get_clean();
            imagedestroy($sourceImage);
        } else {
            $jpegImage = file_get_contents($fileData['image']['tmp_name']);
        }

        $uuid = Uuid::uuid4()->toString();

        $slug = $this->generateSlug(htmlspecialchars($postData['title']), htmlspecialchars($postData['game_type']));

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

        $language = htmlspecialchars($postData['language']);

        $localizationData = [
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

    private function generateSlug($title, $gameType): ?string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $existingGamesCount = (new GamesModel($this->GamePDO))->getCountOfGamesBySlug($slug, $gameType);

        if ($existingGamesCount === null) return null;

        if ($existingGamesCount > 0) {
            $slug .= '-' . $existingGamesCount;
        }

        return $slug;
    }
}
