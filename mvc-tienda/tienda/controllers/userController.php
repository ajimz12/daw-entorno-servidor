<?php
require_once("models/User.php");
require_once("models/UserRepository.php");

if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $hashedPassword = md5($_POST['password']);
        $user = UserRepository::login($_POST['username'], $hashedPassword);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: index.php'); // Redirige a la página principal después del login
            exit();
        } else {
            $info = "Error en el login";
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php?c=login');
    exit();
}

require_once("views/LoginView.phtml");
