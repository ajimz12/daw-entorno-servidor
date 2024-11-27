<?php

require_once("models/User.php");
require_once("models/PlaylistRepository.php");
require_once("models/Playlist.php");

session_start();

if (isset($_GET['c']) && $_GET['c'] === 'login') {
    require_once("controllers/userController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'register') {
    require_once("controllers/userController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'playlist') {
    require_once("controllers/playlistController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'song') {
    require_once("controllers/songController.php");
    exit();
}

if (isset($_SESSION['user'])) {

    $playlists = PlaylistRepository::getAllPlaylistsByUser($_SESSION['user']);
    $favoritePlaylists = PlaylistRepository::getAllFavoritePlaylists($_SESSION['user']);
}


require_once("views/mainView.phtml");
