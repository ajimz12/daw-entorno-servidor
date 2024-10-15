<?php

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    require_once("controllers/userController.php");
    exit();
}


if (isset($_POST['login'])) {
    if (isset($_POST['username']) && $_POST['password']) {
        $hashedPassword = md5($_POST['password']);

        if ($_SESSION['user'] = UserRepository::login($_POST['username'], $hashedPassword)) {
            header('Location: index.php');
            exit();
        } else {
            $info = "Error en el login";
        }
    }
}

require_once('views/LoginView.phtml');
