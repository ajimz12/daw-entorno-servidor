<?php

class Playlist
{
    private $id;
    private $title;
    private $totalDuration;
    private $userId;
    private $songs;

    function __construct($datos)
    {
        $this->id = $datos['id'];
        $this->title = $datos['title'];
        $this->totalDuration = $datos['totalDuration'];
        $this->userId = $datos['userId'] ?? null;
        $this->songs = PlaylistRepository::getAllSongsByPlaylist($this);
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

    public function getUser()
    {
        return PlaylistRepository::getPlaylistUser($this);
    }

    public function getSongs()
    {
        return $this->songs;
    }

    public function getNumberOfSongs()
    {
        return count($this->songs);
    }
}
