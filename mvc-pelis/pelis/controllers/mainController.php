<?php

//cargamos el modelo
require_once("models/Peli.php");
require_once("models/User.php");
require_once("models/PeliRepository.php");
require_once("models/UserRepository.php");


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
            require_once("controllers/movieController.php");
            die();
            // $movie = PeliRepository::getMovieById($_GET['id']);
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

if (isset($_GET['showUniqueMovie'])) {
    $movies = PeliRepository::getMovieById($_POST['showUniqueMovie']);
} else {
    $movies = PeliRepository::getMovies();
}

// cargar la vista
require_once("views/ListView.phtml");
