<?php
require_once("./models/UserRepository.php");
require_once("./models/ThemeRepository.php");

class Comment
{
    private $id;
    private $text;
    private $date;
    private $hidden;
    private $user;
    private $theme;

    public function __construct($data)
    {
        $this->id = $data['comment_id'];
        $this->text = $data['comment_text'];
        $this->date = $data['comment_date'];
        $this->hidden = $data['hidden'];
        $this->user = UserRepository::getUserById($data['user_id']);
        $this->theme = ThemeRepository::getThemeById($data['theme_id']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTheme()
    {
        return $this->theme;
    }
}
