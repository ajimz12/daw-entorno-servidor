<?php

/**
 * 
 */

class UserRepository
{

    public static function getUsers()
    {
        $db = Conectar::conexion();
        $users = array();
        $result = $db->query("SELECT * FROM users");

        while ($row = $result->fetch_assoc()) {
            $users[] = new Peli($row);
        }
        return $users;
    }

    public static function login($username, $password)
    {
        $query = "SELECT * FROM usuarios WHERE username = '" . $username . "' AND password = '" . $password . "'";
        $result = Conectar::conexion()->query($query);
        if ($row = $result->fetch_assoc()) {
            return new User($row['id'], $row['username']);
        } else {
            return false;
        }
    }
}
