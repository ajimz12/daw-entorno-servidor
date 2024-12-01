<?php

class ForumRepository
{
    public static function getAllForums()
    {
        $db = Connect::connection();
        $query = "SELECT * FROM forums f JOIN users u ON f.user_id = u.user_id";
        $result = $db->query($query);
        $forums = [];
        while ($row = $result->fetch_assoc()) {
            $forum = new Forum($row);
            $forums[] = $forum;
        }
        return $forums;
    }


    public static function getForumById($forumId)
    {
        $db = Connect::connection();
        $result = $db->query("SELECT * FROM forums WHERE forum_id = " . $forumId);

        if ($row = $result->fetch_assoc()) {
            return new Forum($row);
        }
        return null;
    }

    
    public static function getThemesByForum($forum)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM themes WHERE forum_id = " . $forum->getId();
        $result = $db->query($query);
        $themes = [];
        while ($row = $result->fetch_assoc()) {
            $theme = new Theme($row);
            $themes[] = $theme;
        }
        return $themes;
    }


    public static function addForum($forum)
    {
        $db = Connect::connection();
        $userId = $_SESSION['user']->getId();
        $query = "INSERT INTO forums (title, description, forum_image, visibility, user_id) VALUES (
            '" . $forum->getTitle() . "',
            '" . $forum->getDescription() . "',
            '" . $forum->getImage() . "',
            '" . $forum->isVisible() . "',
            '" . $userId . "'
        )";

        $db->query($query);
        header("Location: index.php");
    }
}
