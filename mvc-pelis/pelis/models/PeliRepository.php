<?php

/**
 * 
 */
class PeliRepository
{
	//metodo para sacar todas las peliculas
	public static function getMovies()
	{
		$db = Conectar::conexion();
		$movies = array();
		$result = $db->query("SELECT * FROM peliculas");
		while ($row = $result->fetch_assoc()) {
			$movies[] = new PeliModel($row);
		}
		return $movies;
	}

	public static function getMovieByTitle($t)
	{
		$db = Conectar::conexion();
		$movies = array();
		$result = $db->query("SELECT * FROM peliculas WHERE titulo LIKE '%" . $t . "%'");
		while ($row = $result->fetch_assoc()) {
			$movies[] = new PeliModel($row);
		}
		return $movies;
	}

	public static function saveMovie($title, $year, $image)
	{
		$db = Conectar::conexion();
		$db->query("INSERT INTO peliculas VALUES (null, '" . $title . "','" . $year . "','" . $_FILES[$image]['name'] . "')");
	}

	public static function saveLike($id)
	{
		$db = Conectar::conexion();
		$db->query("UPDATE peliculas SET likes = likes + 1 WHERE id = " . $id);
	}
}
