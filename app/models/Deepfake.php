<?php

namespace app\models;

class Deepfake
{
    private string $nom;
    private string $imageUrl;
    private bool $isVraiImage;
    private string $hint;
    private string $explaination;

    function __construct($nom, $imageUrl, $isVraiImage, $hint, $explaination){
        $this->nom = $nom;
        $this->imageUrl = $imageUrl;
        $this->isVraiImage = $isVraiImage;
        $this->hint = $hint;
        $this->explaination = $explaination;
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
    /**
     * @return mixed
     */
    public function getExplaination(): string
    {
        return $this->explaination;
    }
}