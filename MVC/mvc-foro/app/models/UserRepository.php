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

    public static function register($username, $email, $password, $avatar, $role, $active)
    {
        $db = Connect::connection();

        $query = "INSERT INTO users (username, email, password, avatar, role, active) VALUES ('" . $username . "', '" . $email . "', '" . $password . "', '" . $avatar . "', '" . $role . "', '" . $active . "')";

        if ($db->query($query)) {
            $userId = $db->insert_id;
            return new User([
                'user_id' => $userId,
                'username' => $username,
                'email' => $email,
                'avatar' => $avatar,
                'role' => $role,
                'active' => 1
            ]);
        }
        return null;
    }

    public static function getUserById($userId)
    {
        $query = "SELECT * FROM users WHERE user_id = " . $userId;
        $result = Connect::connection()->query($query);
        if ($row = $result->fetch_assoc()) {
            return new User($row);
        }
        return null;
    }
}
