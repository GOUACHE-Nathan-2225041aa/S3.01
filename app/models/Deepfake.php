<?php

namespace app\models;

class Deepfake
{
    private string $nom;
    private string $imageUrl;
    private bool $isVraiImage;
    private string $hint;

    function __construct($nom, $imageUrl, $isVraiImage, $hint){
        $this->nom = $nom;
        $this->imageUrl = $imageUrl;
        $this->isVraiImage = $isVraiImage;
        $this->hint = $hint;
    }

    /**
     * @return mixed
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }
    /**
     * @return mixed
     */
    public function getIsVraiImage(): bool
    {
        return $this->isVraiImage;
    }
    /**
     * @return mixed
     */
    public function getHint(): string
    {
        return $this->hint;
    }
}