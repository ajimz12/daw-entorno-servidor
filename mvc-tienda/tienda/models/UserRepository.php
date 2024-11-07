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
        $db = Connect::connection();
        $query = "INSERT INTO users (username, password, isAdmin) VALUES ('" . $username . "', '" . $password .  "', '" . 0 . "')";
        if ($db->query($query)) {
            $userId = $db->insert_id;
            return new User([
                'user_id' => $userId,
                'username' => $username,
                'isAdmin' => false
            ]);
        }
        return null;
    }

    public static function getAllUsers()
    {
        $db = Connect::connection();
        $users = array();
        $query = "SELECT * FROM users";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row);
        }
        return $users;
    }

    public static function getUserById($userId)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM users WHERE user_id = '$userId'";
        $result = $db->query($query);
        if ($row = $result->fetch_assoc()) {
            return new User($row);
        }
        return null;
    }

    public static function getTopUsers()
    {
        $db = Connect::connection();
        $result = $db->query("SELECT user_id, SUM(total) as total FROM orders GROUP BY order_id ORDER BY total DESC LIMIT 5");
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $user = UserRepository::getUserById($row['user_id']);
            if ($user) {
                $users[] = $user;
            }
        }
        return $users;
    }
}
