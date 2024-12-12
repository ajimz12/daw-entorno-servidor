<?php

class User
{
    private $id;
    private $username;

    function __construct($data)
    {
        $this->id = $data['user_id'];
        $this->username = $data['username'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
