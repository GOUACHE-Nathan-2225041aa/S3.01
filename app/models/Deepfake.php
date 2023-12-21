<?php

namespace app\models;

class Deepfake
{
    private string $nom;
    private string $ressourceUrl;
    private bool $isVraiImage;

    function __construct($nom, $ressourceUrl, $isVraiImage){
        $this->nom = $nom;
        $this->ressourceUrl = $ressourceUrl;
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
    public function getRessourceUrl(): string
    {
        return $this->ressourceUrl;
    }

    /**
     * @return mixed
     */
    public function getIsVraiImage(): bool
    {
        return $this->isVraiImage;
    }
}