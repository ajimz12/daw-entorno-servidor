<?php

class User
{

    private $user_id;
    private $username;

    function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->username = $data['username'];
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
