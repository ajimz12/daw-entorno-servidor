<?php

require_once("./models/Forum.php");
require_once("./models/ForumRepository.php");

if (isset($_POST['addForum'])) {
    $forumTitle = $_POST['forumTitle'];
    $forumDescription = $_POST['forumDescription'];
    $visibility = isset($_POST['visible']) ? 1 : 0;

    $forumImage = "";
    if (isset($_FILES['forumImage']['name']) && $_FILES['forumImage']['name'] != '') {
        $forumImage = "./public/forum-img/" . $_FILES['forumImage']['name'];
        if (!move_uploaded_file($_FILES['forumImage']['tmp_name'], $forumImage)) {
            echo "Error al mover el archivo";
            $forumImage = "./public/forum-img/default-image.jpg"; 
        }
    } else {
        $forumImage = "./public/forum-img/default-image.jpg";
    }


    $data = [
        'title' => $forumTitle,
        'description' => $forumDescription,
        'image' => $forumImage,
        'visibility' => $visibility,
        'user_id' => $_SESSION['user']->getId()
    ];

    $forum = new Forum($data);
    ForumRepository::addForum($forum);
}
