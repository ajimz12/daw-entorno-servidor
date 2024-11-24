<?php

require_once("models/Song.php");
require_once("models/SongRepository.php");


if (isset($_GET["viewSongs"])) {
    $songs = SongRepository::getAllSongs();
    require_once("views/songListView.phtml");
}

if (isset($_POST['searchSong'])) {
    $songs = SongRepository::getSongByTitle($_POST['searchSong']);
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
        $uploadDir = './data/mp3/';
        $uploadPath = $uploadDir . basename($mp3File['name']);
        $urlFile = $uploadPath;

        if (move_uploaded_file($mp3File['tmp_name'], $uploadPath)) {
            SongRepository::addSong($songName, $author, $duration, $urlFile, $user);
            header('Location: index.php');
            exit();
        }
    }
}

require_once("views/songListView.phtml");
