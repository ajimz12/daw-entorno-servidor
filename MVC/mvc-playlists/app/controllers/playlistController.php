<?php

require_once("models/Playlist.php");
require_once("models/PlaylistRepository.php");

if (isset($_GET['addPlaylist'])) {
    $user = $_SESSION['user'];
    $playlistName = $_POST['playlistName'];
    $totalDuration = 0;
    PlaylistRepository::addPlaylist($playlistName, $totalDuration, $user);
    header('Location: index.php');
    exit();
}

if(isset($_GET['playlist_id'])){
    $playlist = PlaylistRepository::getPlaylistById($_GET['playlist_id']);
    require_once("views/playListView.phtml");
    exit();
}
