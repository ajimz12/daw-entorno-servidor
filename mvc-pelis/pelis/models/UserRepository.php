<?php

class UserRepository
{

    public static function login($username, $password)
    {
        $query = "SELECT * FROM usuarios WHERE username = '" . $username . "' AND password = '" . $password . "'";
        $result = Conectar::conexion()->query($query);
        if ($row = $result->fetch_assoc()) {
            return new User($row);
        } else {
            return false;
        }
    }

    public static function getUsers()
    {
        $db = Conectar::conexion();
        $users = array();
        $result = $db->query("SELECT * FROM usuarios");
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row);
        }
        return $users;
    }

    public static function getUserById($id)
    {
        $db = Conectar::conexion();
        $users = array();
        $result = $db->query("SELECT * FROM usuarios WHERE id = " . $id);

        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row);
        }
        return $users;
    }

    public static function getFavorites($userId)
	{
		$db = Conectar::conexion();
		$movies = array();
		$result = $db->query("SELECT movie_id FROM favoritos WHERE user_id = $userId");
		while ($row = $result->fetch_assoc()) {
			$movies[] = PeliRepository::getMovieById($row['movie_id']);
		}
		return $movies;
	}
}

