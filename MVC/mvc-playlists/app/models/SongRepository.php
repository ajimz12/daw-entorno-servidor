<?php

class SongRepository
{

    public static function getAllSongs()
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

    public static function getSongByTitle($title)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM songs WHERE title LIKE '%" . $title . "%'";
        $result = $db->query($query);
        $songs = array();
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row);
        }
        return $songs;
    }

    public static function getSongByAuthor($author)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM songs WHERE author LIKE '%" . $author . "%'";
        $result = $db->query($query);
        $songs = array();
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row);
        }
        return $songs;
    }

    public static function getSongByUser($user)
    {
        $userId = $user->getId();
        $db = Connect::connection();

        $query = "SELECT * FROM songs WHERE user_id = '$userId'";
        $result = $db->query($query);
        $songs = array();
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row);
        }
        return $songs;
    }

    public static function addSong($title, $author, $duration, $urlFile, $user)
    {
        $db = Connect::connection();
        $query = "INSERT INTO songs (title, author, duration, urlFile, user_id) VALUES ('" . $title . "', '" . $author . "', '" . $duration
            . "', '" . $urlFile .  "', '" . $user->getId() . "')";
        if ($db->query($query)) {
            $playlistId = $db->insert_id;
            return new Song([
                'id' => $playlistId,
                'title' => $title,
                'author' => $author,
                'duration' => $duration,
                'urlFile' => $urlFile
            ]);
        } else {
            return false;
        }
    }

    public static function addSongToPlaylist($playlist, $song)
    {
        $db = Connect::connection();
        $playlistId = $playlist->getId();
        $songId = $song->getId();
        $query = "INSERT INTO playlists_songs (playlist_id, song_id) VALUES ('$playlistId', '$songId'))";
        return $db->query($query);
    }
}
