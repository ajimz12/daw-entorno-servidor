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
			$movies[] = new Peli($row);
		}
		return $movies;
	}

	public static function getMovieByTitle($t)
	{
		$db = Conectar::conexion();
		$movies = array();
		$result = $db->query("SELECT * FROM peliculas WHERE title LIKE '%" . $t . "%'");
		while ($row = $result->fetch_assoc()) {
			$movies[] = new Peli($row);
		}
		return $movies;
	}

	public static function saveMovie($title, $year, $image)
	{
		$db = Conectar::conexion();
		$db->query("INSERT INTO peliculas VALUES (null, '" . $title . "','" . $year . "','" . $image . "','" . 0 . "')");
	}

	public static function deleteMovie($id)
	{
		$db = Conectar::conexion();
		$db->query("DELETE FROM peliculas WHERE id = " . $id);
	}

	public static function saveLike($id)
	{
		$db = Conectar::conexion();
		$db->query("UPDATE peliculas SET likes = likes + 1 WHERE id = " . $id);
	}
}
