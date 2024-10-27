<?php

require_once("models/User.php");
require_once("models/UserRepository.php");

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