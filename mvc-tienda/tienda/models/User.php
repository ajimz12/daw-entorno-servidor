<?php

class User
{

    private $user_id;
    private $username;
    private $isAdmin;

    function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->username = $data['username'];
        $this->isAdmin = $data['isAdmin'];
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }
}
