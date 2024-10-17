<?php

require_once("models/Peli.php");
require_once("models/PeliRepository.php");

if (isset($_GET['id'])) {
    $movie = PeliRepository::getMovieById($_GET['id']);
    
    if ($movie) {
        require_once('views/MovieView.phtml');
    } 
}
