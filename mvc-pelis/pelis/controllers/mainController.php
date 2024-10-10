<?php
//cargamos el modelo
require_once("models/PeliModel.php");
require_once("models/PeliRepository.php");


if (isset($_POST['busca'])) {
    //usar el repositorio para cargar los datos
    $movies = PeliRepository::getMovieByTitle($_POST['busca']);
} else
    $movies = PeliRepository::getMovies();

if (isset($_POST['saveMovie'])) {

    if (isset($_FILES['image']['name'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], "./img/" . $_FILES['image']['name']);
    }

    PeliRepository::saveMovie($_POST['title'], $_POST['year'], $_FILES['image']['name']);
    header('Location: index.php');
}

if (isset($_GET['likeMovie'])) {
    PeliRepository::saveLike($_GET['id']);
    header('Location: index.php');
}

// cargar la vista
require_once("views/ListView.phtml");
