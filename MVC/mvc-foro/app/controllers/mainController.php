<?php

require_once("models/User.php");
require_once("models/Forum.php");
require_once("models/ForumRepository.php");

session_start();

$forums = ForumRepository::getAllForums();

if (isset($_GET['c']) && $_GET['c'] === 'login') {
    require_once("controllers/userController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'register') {
    require_once("controllers/userController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'forum') {
    require_once("controllers/forumController.php");
    exit();
}

require_once("views/mainView.phtml");
