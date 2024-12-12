<?php

require_once("./models/Song.php");

class PlaylistRepository
{

    public static function getAllPlaylists()
    {
        $db = Connect::connection();
        $playlists = array();
        $result = $db->query("SELECT * FROM playlists");
        while ($row = $result->fetch_assoc()) {
            $playlists[] = new Playlist($row);
        }
        return $playlists;
    }

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

    public static function getPlaylistByTitle($title)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM playlists WHERE title LIKE '%" . $title . "%'";
        $result = $db->query($query);
        $playlists = array();
        while ($row = $result->fetch_assoc()) {
            $playlists[] = new Playlist($row);
        }
        return $playlists;
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

    public static function getAllFavoritePlaylists($user)
    {
        $db = Connect::connection();

        $userId = $user->getId();
        $playlists = array();

        $result = $db->query("SELECT * FROM playlists JOIN favorites ON(playlists.id = favorites.id_playlist) WHERE favorites.id_user = '" . $userId . "'");

        while ($row = $result->fetch_assoc()) {
            $playlists[] = new Playlist($row);
        }

        return $playlists;
    }


    public static function getAllSongsByPlaylist($playlist)
    {
        $playlistId = $playlist->getId();
        $db = Connect::connection();
        $result = $db->query("SELECT * FROM songs JOIN playlists_songs WHERE playlists_songs.song_id = songs.id AND playlists_songs.playlist_id = '$playlistId'");
        $songs = array();
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row);
        }
        return $songs;
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

    public static function addSongToPlaylist($playlistName, $songId)
    {
        $db = Connect::connection();

        $query = "INSERT INTO playlists_songs (playlist_id, song_id) 
                  VALUES ((SELECT id FROM playlists WHERE playlists.title = '" . $playlistName . "'), '$songId')";

        if ($db->query($query)) {
            $playlistIdResult = $db->query("SELECT id FROM playlists WHERE title = '" . $playlistName . "'");
            if ($playlistIdRow = $playlistIdResult->fetch_assoc()) {
                $playlistId = $playlistIdRow['id'];

                self::updatePlaylistDuration($playlistId);
            }
        }

        return false;
    }

    public static function updatePlaylistDuration($playlistId)
    {
        $db = Connect::connection();

        $query = "SELECT SUM(songs.duration) as totalDuration 
              FROM songs 
              JOIN playlists_songs ON songs.id = playlists_songs.song_id 
              WHERE playlists_songs.playlist_id = '$playlistId'";

        $result = $db->query($query);

        if ($row = $result->fetch_assoc()) {
            $totalDuration = $row['totalDuration'] ?? 0;
        } else {
            $totalDuration = 0;
        }

        $updateQuery = "UPDATE playlists SET totalDuration = '$totalDuration' WHERE id = '$playlistId'";
        return $db->query($updateQuery);
    }

    public static function addPlaylistToFavorites($playlist)
    {
        $db = Connect::connection();
        $userId = $_SESSION['user']->getId();
        $query = "INSERT INTO favorites (id_user, id_playlist) VALUES ('$userId', '" . $playlist->getId() . "')";
        $db->query($query);
    }
}
