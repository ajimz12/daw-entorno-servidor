<?php

class CommentRepository
{

    public static function addComment($comment)
    {
        $connection = Connect::connection();
        $query = "INSERT INTO comments (comment_text, comment_date, user_id, theme_id, hidden) VALUES (
            '" . $comment->getText() . "',
            '" . $comment->getDate() . "',
            '" . $comment->getUser()->getId() . "',
            '" . $comment->getTheme()->getId() . "',
            '" . $comment->isHidden() . "'
        )";
        $connection->query($query);
        header("Location: index.php?c=theme&showTheme=1&theme_id=" . $comment->getTheme()->getId());
    }
}
