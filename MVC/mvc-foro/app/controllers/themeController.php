<?php

require_once("./models/Theme.php");
require_once("./models/Comment.php");
require_once("./models/ThemeRepository.php");
require_once("./models/CommentRepository.php");

if (isset($_POST['addTheme'])) {
    $themeTitle = $_POST['themeTitle'];
    $themeContent = $_POST['themeContent'];

    $themeImage = "";
    if (isset($_FILES['themeImage']['name']) && $_FILES['themeImage']['name'] != '') {
        $uploadDir = "./public/theme-img/";
        $uploadedFile = $uploadDir . basename($_FILES['themeImage']['name']);
        if (move_uploaded_file($_FILES['themeImage']['tmp_name'], $uploadedFile)) {
            $themeImage = $uploadedFile;
        } else {
            echo "Error al mover el archivo";
            $themeImage = "";
        }
    }


    $data = [
        'theme_title' => $themeTitle,
        'content' => $themeContent,
        'theme_image' => $themeImage,
        'user_id' => $_SESSION['user']->getId(),
        'forum_id' => $_POST['forum_id'],
        'hidden' => 0,
    ];

    $theme = new Theme($data);
    ThemeRepository::addTheme($theme);
}

if (isset($_GET['showTheme'])) {
    $theme = ThemeRepository::getThemeById($_GET['theme_id']);
    require_once("views/themeView.phtml");
    exit();
}

if (isset($_GET['hideTheme'])) {
    ThemeRepository::updateThemeVisibility($_GET['theme_id'], $_GET['hiddenTheme']);
    header('Location: index.php?c=theme&showTheme=1&theme_id=' . $_GET['theme_id']);
    exit();
}

if (isset($_GET['hideComment'])) {
    CommentRepository::updateCommentVisibility($_GET['comment_id'], $_GET['hiddenComment']);
    header('Location: index.php?c=theme&showTheme=1&theme_id=' . $_GET['theme_id']);
    exit();
}

if (isset($_POST['addComment'])) {
    $commentContent = $_POST['commentText'];
    $commentDate = date("Y-m-d H:i:s");

    $data = [
        'comment_text' => $commentContent,
        'comment_date' => $commentDate,
        'user_id' => $_SESSION['user']->getId(),
        'theme_id' => $_POST['theme_id'],
        'hidden' => 0,
    ];

    $comment = new Comment($data);
    CommentRepository::addComment($comment);
}
