<?php

class PlaylistRepository
{

    public static function getAllPlaylistsByUser($user)
    {
        $db = Connect::connection();

        $userId = $user->getId();
        $playlists = array();

        $result = $db->query("SELECT * FROM playlists WHERE user_id = '$userId'");

        while ($row = $result->fetch_assoc()) {
            $playlists[] = new Playlist($row);
        }

        return $playlists;
    }

    public static function getPlaylistById($playlistId)
    {
        $db = Connect::connection();
        $result = $db->query("SELECT * FROM playlists WHERE id = '$playlistId'");
        if ($row = $result->fetch_assoc()) {
            return new Playlist([
                'id' => $row['id'],
                'title' => $row['title'],
                'totalDuration' => $row['totalDuration'],
                'userId' => $row['user_id']
            ]);
        } else {
            return false;
        }
    }

    public static function getPlaylistUser($playlist)
    {

        $userId = $playlist->getUserId();
        if (!$userId) {
            return false;
        }

        $db = Connect::connection();
        $result = $db->query("SELECT * FROM users WHERE id = '" . $playlist->getUserId() . "'");
        if ($row = $result->fetch_assoc()) {
            return new User($row);
        } else {
            return false;
        }
    }



    public static function addPlaylist($title, $totalDuration, $user)
    {
        $db = Connect::connection();
        $query = "INSERT INTO playlists (title, totalDuration, user_id) VALUES ('" . $title . "', '" . $totalDuration . "', '" . $user->getId() . "')";
        if ($db->query($query)) {
            $playlistId = $db->insert_id;
            return new Playlist([
                'id' => $playlistId,
                'title' => $title,
                'totalDuration' => $totalDuration,
                'userId' => $user->getId()
            ]);
        } else {
            return false;
        }
    }
}
