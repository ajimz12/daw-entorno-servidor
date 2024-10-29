<?php

class UserRepository
{

    public static function login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
        $result = Connect::connection()->query($query);
        if ($row = $result->fetch_assoc()) {
            return new User($row);
        } else {
            return false;
        }
    }

    public static function register($username, $password)
    {
        $query = "INSERT INTO users (username, password, isAdmin) VALUES ('" . $username . "', '" . $password .  "', '" . 0 ."')";
        $result = Connect::connection()->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
