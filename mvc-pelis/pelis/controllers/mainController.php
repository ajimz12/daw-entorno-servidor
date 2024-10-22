<?php

//cargamos el modelo
require_once("models/Peli.php");
require_once("models/User.php");
require_once("models/PeliRepository.php");
require_once("models/UserRepository.php");

session_start();

if (isset($_GET['c'])) {
    switch ($_GET['c']) {
        case 'login':
            require_once("controllers/userController.php");
            die();
        case 'user':
            // Login
            if (isset($_POST['username']) && isset($_POST['password'])) {
                require_once("controllers/userController.php");
                die();
            }
        case 'movie':
            // Pelicula
            require_once("controllers/movieController.php");
            die();
        case 'userList':
            // Lista de usuarios
            require_once("controllers/userController.php");
            die();

        case 'userDetail':
            // Usuario
            require_once("controllers/userController.php");
            die();
    }
}


if (isset($_POST['busca'])) {
    $movies = PeliRepository::getMovieByTitle($_POST['busca']);
} else {
    $movies = PeliRepository::getMovies();
}


if (isset($_POST['saveMovie'])) {
    if (isset($_FILES['image'])) {

        $dir = "./public/img/";
        $imageName = basename($_FILES["image"]["name"]);
        $dir = $dir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $dir)) {
            if (PeliRepository::saveMovie($_POST['title'], $_POST['year'], $imageName)) {
            }
        }
    }
    header(header: 'Location: index.php');
}

if (isset($_GET['deleteMovie'])) {
    PeliRepository::deleteMovie($_GET['id']);
    header('Location: index.php');
}

if (isset($_GET['likeMovie'])) {
    PeliRepository::saveLike($_GET['id']);
    header('Location: index.php');
}


if (isset($_GET['setFavorite']) && isset($_GET['id']) && isset($_SESSION['user'])) {
    $userId = $_SESSION['user']->getId();
    $movieId = $_GET['id'];
    PeliRepository::addToFavorites($userId, $movieId);
    header('Location: index.php');
    die();
}


// cargar la vista
require_once("views/ListView.phtml");
