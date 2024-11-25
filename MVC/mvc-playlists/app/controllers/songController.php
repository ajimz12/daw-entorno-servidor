<?php

require_once("models/Song.php");
require_once("models/SongRepository.php");
require_once("models/PlaylistRepository.php");


$userSongs = SongRepository::getSongByUser($_SESSION["user"]);
$playlists = PlaylistRepository::getAllPlaylistsByUser($_SESSION["user"]);

if (isset($_GET["viewSongs"])) {
    $songs = SongRepository::getAllSongs();
}

if (isset($_POST['searchSong']) && isset($_POST['searchType'])) {
    $searchQuery = trim($_POST['searchSong']);
    $searchType = $_POST['searchType'];

    if ($searchType === "title") {
        $songs = SongRepository::getSongByTitle($searchQuery);
    } elseif ($searchType === "author") {
        $songs = SongRepository::getSongByAuthor($searchQuery);
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

    if (isset($_FILES['mp3File']) && $_FILES['mp3File']['error'] === UPLOAD_ERR_OK) {
        $mp3File = $_FILES['mp3File'];
        $uploadDir = './public/mp3/';
        $uploadPath = $uploadDir . basename($mp3File['name']);
        $urlFile = $uploadPath;

        if (move_uploaded_file($mp3File['tmp_name'], $uploadPath)) {
            SongRepository::addSong($songName, $author, $duration, $urlFile, $user);
            header('Location: index.php');
            exit();
        }
    }
}

if (isset($_GET["addSongToPlaylist"])) {
    $playlist = $_POST['playlists'];
    $song = $_GET['songId'];
    SongRepository::addSongToPlaylist($playlist, $song);
}

require_once("views/songListView.phtml");
