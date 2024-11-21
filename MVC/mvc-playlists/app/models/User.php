<?php

class User
{

    private $id;
    private $username;
    private $role;
    function __construct($datos)
    {
        $this->id = $datos['id'];
        $this->username = $datos['username'];
        $this->role = $datos['role'];
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
