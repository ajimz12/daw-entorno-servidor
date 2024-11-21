<?php

class Playlist
{

    private $id;
    private $title;
    private $totalDuration;
    private $userId;

    function __construct($datos)
    {
        $this->id = $datos['id'];
        $this->title = $datos['title'];
        $this->totalDuration = $datos['totalDuration'];
        $this->userId = $datos['userId'];
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

    public function getUserId()
    {
        return $this->userId;
    }
}
