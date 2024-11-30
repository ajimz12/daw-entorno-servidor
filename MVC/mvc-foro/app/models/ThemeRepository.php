<?php

class ThemeRepository
{

    public static function getAllThemes()
    {
        $db = Connect::connection();
        $query = "SELECT * FROM themes t JOIN users u ON t.user_id = u.user_id JOIN forums f ON t.forum_id = f.forum_id";
        $result = $db->query($query);
        $themes = [];
        while ($row = $result->fetch_assoc()) {
            $theme = new Theme($row);
            $themes[] = $theme;
        }
        return $themes;
    }


    public static function getThemeById($themeId)
    {
        $db = Connect::connection();
        $result = $db->query("SELECT * FROM themes WHERE theme_id = " . $themeId);

        if ($row = $result->fetch_assoc()) {
            return new Theme($row);
        }
        return null;
    }

    public static function addTheme($theme)
    {
        $db = Connect::connection();
        $query = "INSERT INTO themes (title, content, theme_image, user_id, forum_id, hidden) VALUES (
            '" . $theme->getTitle() . "',
            '" . $theme->getContent() . "',
            '" . $theme->getImage() . "',
            '" . $theme->getUser()->getId() . "',
            '" . $theme->getForum()->getId() . "',
            '" . $theme->isHidden() . "'
        )";


        if ($db->query($query)) {
            header("Location: index.php?c=forum&showForum=1&forum_id=" . $theme->getForum()->getId());
            exit();
        }

        return null;
    }
}
