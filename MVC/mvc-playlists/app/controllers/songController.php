<?php

require_once("models/Song.php");
require_once("models/SongRepository.php");
require_once("models/PlaylistRepository.php");

if (isset($_SESSION['user'])) {
    $userSongs = SongRepository::getSongByUser($_SESSION["user"]);
    $playlists = PlaylistRepository::getAllPlaylistsByUser($_SESSION['user']);
}

if (isset($_POST['searchSong']) && isset($_POST['searchType'])) {
    $searchParam = trim($_POST['searchSong']);
    $searchType = $_POST['searchType'];

    if ($searchType === "title") {
        $songs = SongRepository::getSongByTitle($searchParam);
    } elseif ($searchType === "author") {
        $songs = SongRepository::getSongByAuthor($searchParam);
    } else {
        $songs = [];
    }
} else {
    $songs = SongRepository::getAllSongs();
}

if (isset($_GET['addSong'])) {
    $user = $_SESSION['user'];
    $songName = $_POST['songName'];
    $author = $_POST['author'];

    $duration = $_POST['duration'];
    list($minutes, $seconds) = explode(':', $duration);
    $totalSeconds = (int)$minutes * 60 + (int)$seconds;

    if (isset($_FILES['mp3File']) && $_FILES['mp3File']['error'] === UPLOAD_ERR_OK) {
        $mp3File = $_FILES['mp3File'];
        $uploadDir = './public/mp3/';
        $uploadPath = $uploadDir . basename($mp3File['name']);
        $urlFile = $uploadPath;

        if (move_uploaded_file($mp3File['tmp_name'], $uploadPath)) {
            SongRepository::addSong($songName, $author, $totalSeconds, $urlFile, $user);
            header('Location: index.php');
            exit();
        }
    }
}


if (isset($_POST["playlists"]) && isset($_POST["song_id"])) {
    $playlist = $_POST['playlists'];
    $songId = $_POST['song_id'];
    PlaylistRepository::addSongToPlaylist($playlist, $songId);
}



require_once("views/songListView.phtml");
