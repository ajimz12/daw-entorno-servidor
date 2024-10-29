
<?php

require_once("models/PeliRepository.php");


if (isset($_GET['showUniqueMovie'])) {
    $movie = PeliRepository::getMovieById($_GET['id']);
    require_once("views/MovieView.phtml");
    die();
}
