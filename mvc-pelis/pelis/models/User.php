<?php

/**
 * 
 */
class User
{

    private $id;
    private $username;

    function __construct($id, $username)
    {
        $this->id = $id;
        $this->username = $username;
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
