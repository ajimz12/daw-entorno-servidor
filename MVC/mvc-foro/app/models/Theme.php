<?php
require_once("./models/UserRepository.php");
require_once("./models/ForumRepository.php");


class Theme
{
    private $id;
    private $title;
    private $content;
    private $image;
    private $user;
    private $forum;
    private $hidden;
    private $comments;


    public function __construct($data)
    {
        $this->id = $data['theme_id'];
        $this->title = $data['theme_title'];
        $this->content = $data['content'];
        $this->image = $data['theme_image'];
        $this->hidden = $data['hidden'];
        $this->user = UserRepository::getUserById(userId: $data['user_id']);
        $this->forum = ForumRepository::getForumById($data['forum_id']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getThemeTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getImage()
    {
        return $this->image ? $this->image : null;
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getForum()
    {
        return $this->forum;
    }

    public function getComments()
    {
        if (!$this->comments) {
            $this->comments = ThemeRepository::getCommentsByTheme($this);;
        }
        return $this->comments;
    }
}
