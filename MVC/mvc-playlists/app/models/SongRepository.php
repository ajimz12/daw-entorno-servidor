<?php

class SongRepository
{

    public function getAllSongs()
    {
        $db = Connect::connection();
        $query = "SELECT * FROM songs";
        $result = $db->query($query);
        $songs = array();
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row);
        }
        return $songs;
    }

    public function addSong(Song $song) {}
}
