<?php

require_once("models/User.php");
require_once("models/UserRepository.php");
require_once("models/PeliRepository.php");

// session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}


if (isset($_POST['login'])) {
    if (isset($_POST['username']) && $_POST['password']) {
        $hashedPassword = md5($_POST['password']);

        if ($_SESSION['user'] = UserRepository::login($_POST['username'], $hashedPassword)) {
            header('Location: index.php');
        } else {
            $info = "Error en el login";
        }
    }
}

if(isset($_GET['login'])){
    require_once("views/LoginView.phtml");
}

if (isset($_GET['showAllUsers'])) {
    $users = UserRepository::getUsers();
    require_once("views/UserListView.phtml");
}

if (isset($_GET['showUniqueUser'])) {
    $users = UserRepository::getUserById($_GET['id']);
    $favorites = UserRepository::getFavorites($_GET['id']);
    require_once("views/UserView.phtml");
}
