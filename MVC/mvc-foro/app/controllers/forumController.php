<?php

require_once("./models/Forum.php");
require_once("./models/ForumRepository.php");
require_once("./models/Theme.php");
require_once("./models/ThemeRepository.php");

$themes = ThemeRepository::getAllThemes();

if (isset($_POST['addForum'])) {
    $forumTitle = $_POST['forumTitle'];
    $forumDescription = $_POST['forumDescription'];
    $visibility = isset($_POST['visible']) ? 1 : 0;

    $forumImage = "";
    if (isset($_FILES['forumImage']['name']) && $_FILES['forumImage']['name'] != '') {
        $uploadDir = "./public/forum-img/";
        $uploadedFile = $uploadDir . basename($_FILES['forumImage']['name']);
        if (move_uploaded_file($_FILES['forumImage']['tmp_name'], $uploadedFile)) {
            $forumImage = $uploadedFile;
        } else {
            echo "Error al mover el archivo";
            $forumImage = "";
        }
    }



    $data = [
        'title' => $forumTitle,
        'description' => $forumDescription,
        'forum_image' => $forumImage,
        'visibility' => $visibility,
        'user_id' => $_SESSION['user']->getId()
    ];

    $forum = new Forum($data);
    ForumRepository::addForum($forum);
}

if (isset($_GET['showForum'])) {
    $forum = ForumRepository::getForumById($_GET['forum_id']);
    require_once("views/forumView.phtml");
    exit();
}
