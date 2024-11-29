<?php

require_once("./models/Forum.php");
require_once("./models/ForumRepository.php");

if (isset($_POST['forum'])) {
    $forumTitle = $_POST['forumTitle'];
    $forumDescription = $_POST['forumDescription'];
    $visibility = $_POST['visibility'];

    $forumImage = "";
    if (isset($_FILES['forumImage']['name']) && $_FILES['forumImage']['name'] != '') {
        $forumImage = $_FILES['forumImage']['name'];
        move_uploaded_file($_FILES['forumImage']['tmp_name'], "./public/forum-img/" . $forumImage);
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
