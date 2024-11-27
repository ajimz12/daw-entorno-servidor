<?php

require_once("models/Playlist.php");
require_once("models/PlaylistRepository.php");


if (isset($_POST['searchPlaylists'])) {
    $searchParam = trim($_POST['playlistTitle']);
    $playlists = PlaylistRepository::getPlaylistByTitle($searchParam);
} else {
    $playlists = PlaylistRepository::getAllPlaylists();
}

if (isset($_GET['addPlaylist'])) {
    $user = $_SESSION['user'];
    $playlistName = $_POST['playlistName'];
    $totalDuration = 0;
    PlaylistRepository::addPlaylist($playlistName, $totalDuration, $user);
    header('Location: index.php');
    exit();
}

if (isset($_GET['playlist_id'])) {
    $playlist = PlaylistRepository::getPlaylistById($_GET['playlist_id']);
    $songs = PlaylistRepository::getAllSongsByPlaylist($playlist);
    require_once("views/playListView.phtml");
    exit();
}

if (isset($_GET['addToFavorites'])) {
    $playlist = PlaylistRepository::getPlaylistById($_GET['playlistIdFavorite']);
    PlaylistRepository::addPlaylistToFavorites($playlist);
    header('Location: index.php?c=playlist&viewPlaylists=1');
    exit();
}

require_once("views/playlistListView.phtml");
