<?php

namespace Model;

class Deepfake
{
    private $nom;
    private $image;
    private $isVraiImage;

    function __construct($nom, $image, $isVraiImage){
        $this->nom = $nom;
        $this->image = $image;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getIsVraiImage()
    {
        return $this->isVraiImage;
    }
}