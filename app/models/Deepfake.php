<?php

namespace app\models;

class DeepfakeModel
{
    private $nom;
    private $imageUrl;
    private $isVraiImage;

    function __construct($nom, $imageUrl, $isVraiImage){
        $this->nom = $nom;
        $this->imageUrl = $imageUrl;
        $this->isVraiImage = $isVraiImage;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return mixed
     */
    public function getIsVraiImage()
    {
        return $this->isVraiImage;
    }
}