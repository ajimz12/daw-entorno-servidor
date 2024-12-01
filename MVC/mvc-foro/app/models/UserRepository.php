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

    public static function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $result = Connect::connection()->query($query);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row);
        }
        return $users;
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

    public static function updateUserActivity($userId, $active)
    {
        $db = Connect::connection();
        $query = "UPDATE users SET active = " . ($active ? 1 : 0) . " WHERE user_id = " . $userId;
        $db->query($query);
    }

    public static function updateUserToAdmin($userId)
    {
        $query = "UPDATE users SET role = 'admin' WHERE user_id = " . $userId;
        Connect::connection()->query($query);
    }
}
