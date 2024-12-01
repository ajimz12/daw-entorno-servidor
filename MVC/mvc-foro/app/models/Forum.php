<?php
require_once("./models/UserRepository.php");
require_once("./models/ThemeRepository.php");

class Forum
{

    private $id;
    private $title;
    private $description;
    private $image;
    private $visibility;
    private $user;
    private $themes;

    public function __construct($data)
    {
        $this->id = $data['forum_id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->image = $data['forum_image'];
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

    public function isVisible()
    {
        return $this->visibility;
    }
    public function getUser()
    {
        return $this->user;
    }

    public function getThemes()
    {
        if (!$this->themes) {
            $this->themes = ForumRepository::getThemesByForum($this);
        }
        return $this->themes;
    }
}
