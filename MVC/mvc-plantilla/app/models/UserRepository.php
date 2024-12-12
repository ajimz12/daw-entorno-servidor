<?php

class UserRepository
{
    public static function login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
        $result = Connection::connect()->query($query);
        if ($row = $result->fetch_assoc()) {
            return new User($row);
        } else {
            return false;
        }
    }

    public static function register($username, $password)
    {
        $db = Connection::connect();
        $query = "INSERT INTO users (username, password) VALUES ('" . $username . "', '" . $password . "')";
        if ($db->query($query)) {
            $userId = $db->insert_id;
            return new User([
                'user_id' => $userId,
                'username' => $username,
            ]);
        }
        return null;
    }
}
