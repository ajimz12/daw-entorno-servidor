<?php

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

	public static function getMovieById($id)
	{
		$db = Conectar::conexion();
		$result = $db->query("SELECT * FROM peliculas WHERE id = " . $id);

		if ($row = $result->fetch_assoc()) {
			return new Peli($row);
		}

		return null;
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

	public static function addToFavorites($userId, $movieId)
	{
		$db = Conectar::conexion();
		$db->query("INSERT INTO favoritos (user_id, movie_id) VALUES ($userId, $movieId)");
	}

	public static function getUsersByMovie($movieId)
	{
		$db = Conectar::conexion();
		$result = $db->query("SELECT user_id FROM favoritos WHERE movie_id = $movieId");
		while ($row = $result->fetch_assoc()) {
			$users[] = UserRepository::getUserById($row['user_id'])[0];
		}
		return $users;
	}
}
