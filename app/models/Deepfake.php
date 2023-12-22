<?php

namespace app\models;

class Deepfake
{
    private string $name;
    private string $sourceUrl;
    private bool $isReal;
    private string $hint;
    private string $explaination;

    function __construct($name, $sourceUrl, $isReal, $hint, $explaination){
        $this->name = $name;
        $this->sourceUrl = $sourceUrl;
        $this->isReal = $isReal;
        $this->hint = $hint;
        $this->explaination = $explaination;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }
    /**
     * @return mixed
     */
    public function getIsReal(): bool
    {
        return $this->isReal;
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