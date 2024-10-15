<?php

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}

if (isset($_POST['login'])) {
    if (isset($_POST['username']) && $_POST['password']) {
        if ($_SESSION['user'] = UserRepository::login($_POST['username'], $_POST['password'])) {
            header('Location: index.php');
        } else {
            $info = "Error en el login";
        }
    }
}

require_once('views/LoginView.phtml');
