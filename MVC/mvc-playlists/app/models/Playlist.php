<?php

class Playlist
{

    private $id;
    private $title;
    private $totalDuration;

    function __construct($datos)
    {
        $this->id = $datos['id'];
        $this->title = $datos['title'];
        $this->totalDuration = $datos['totalDuration'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getTotalDuration()
    {
        return $this->totalDuration;
    }

}
