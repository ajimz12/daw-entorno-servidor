<?php

class ForumRepository
{
    public static function getAllForums()
    {
        $db = Connect::connection();
        $query = "SELECT * FROM forums";
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
        $query = "SELECT * FROM forums WHERE id = $forumId";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $forum = new Forum($row);
            return $forum;
        }

        return null;
    }

    public static function addForum($forum)
    {
        $db = Connect::connection();
        $userId = $_SESSION['user']->getId();
        $query = "INSERT INTO forums (title, description, image, visibility, user_id) VALUES (
            '" . $forum->getTitle() . "',
            '" . $forum->getDescription() . "',
            '" . $forum->getImage() . "',
            '" . $forum->getVisibility() . "',
            '" . $userId . "'
        )";

        $db->query($query);
        header("Location: index.php");
    }
}
