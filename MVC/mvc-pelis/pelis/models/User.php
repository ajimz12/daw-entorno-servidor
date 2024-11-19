<?php

class User
{

    private $id;
    private $username;

    function __construct($datos)
    {
        $this->id = $datos['id'];
        $this->username = $datos['username'];
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
