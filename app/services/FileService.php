<?php

namespace app\services;

class FileService
{
    public static function isImageValid($fileData): void
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
    }

    public static function isAudioValid($fileData): void
    {
        if (!is_uploaded_file($fileData['audio']['tmp_name'])) {
            $_SESSION['errorMessage'] = 'Missing audio';
            header('Location: /admin');
            exit();
        }
        if ($fileData['audio']['type'] != 'audio/mpeg') {
            $_SESSION['errorMessage'] = 'Wrong audio type';
            header('Location: /admin');
            exit();
        }
        if ($fileData['audio']['size'] > 5 * 1024 * 1024) {
            $_SESSION['errorMessage'] = 'Audio too big';
            header('Location: /admin');
            exit();
        }
    }

    public static function convertPngToJpg($fileData): string
    {
        if ($fileData['image']['type'] == 'image/png') {
            $sourceImage = imagecreatefrompng($fileData['image']['tmp_name']);
            ob_start();
            imagejpeg($sourceImage, null, 75);
            $jpegImage = ob_get_clean();
            imagedestroy($sourceImage);
        } else {
            $jpegImage = file_get_contents($fileData['image']['tmp_name']);
        }
        return $jpegImage;
    }
}
