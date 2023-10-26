<?php

namespace app\models;

class Deepfake
{
    private string $nom;
    private string $imageUrl;
    private bool $isVraiImage;

    function __construct($nom, $imageUrl, $isVraiImage){
        $this->nom = $nom;
        $this->imageUrl = $imageUrl;
        $this->isVraiImage = $isVraiImage;
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
}