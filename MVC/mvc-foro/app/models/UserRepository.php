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

    public static function register($username, $email, $password, $avatar,  $role)
    {
        $db = Connect::connection();

        $query = "INSERT INTO users (username, email, password, avatar, role) VALUES ('" . $username . "', '" . $email . "', '" . $password . "', '" . $avatar . "', '" . $role . "')";

        if ($db->query($query)) {
            $userId = $db->insert_id;
            return new User([
                'user_id' => $userId,
                'username' => $username,
                'email' => $email,
                'avatar' => $avatar,
                'role' => $role
            ]);
        }
        return null;
    }
}
