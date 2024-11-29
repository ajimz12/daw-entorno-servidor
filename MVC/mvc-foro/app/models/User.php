<?php

class User
{
    private $id;
    private $username;
    private $email;
    private $avatar;
    private $role;

    function __construct($data)
    {
        $this->id = $data['user_id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->avatar = $data['avatar'];
        $this->role = $data['role'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getRole()
    {
        return $this->role;
    }
}
