<?php

class Song
{
    private $id;
    private $title;
    private $author;
    private $duration;
    private $urlFile;

    public function __construct($datos)
    {
        $this->id = $datos['id'];
        $this->title = $datos['title'];
        $this->author = $datos['author'];
        $this->duration = $datos['duration'];
        $this->urlFile = $datos['urlFile'];
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function getUrlFile()
    {
        return $this->urlFile;
    }
}
