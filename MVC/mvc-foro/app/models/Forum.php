<?php
require_once("./models/UserRepository.php");

class Forum
{

    private $id;
    private $title;
    private $description;
    private $image;
    private $visibility;
    private $user;

    public function __construct($data)
    {
        $this->id = $data['forum_id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->image = $data['image'];
        $this->visibility = $data['visibility'];
        $this->user = UserRepository::getUserById($data['user_id']);

    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }
    public function getUser()
    {
        return $this->user;
    }
}
