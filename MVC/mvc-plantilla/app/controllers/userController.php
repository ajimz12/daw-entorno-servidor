<?php

require_once("models/User.php");
require_once("models/UserRepository.php");


if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $hashedPassword = md5($_POST['password']);
        $user = UserRepository::login($_POST['username'], $hashedPassword);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit();
        } else {
            $info = "Datos incorrectos";
        }
    }
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // $avatar = "./public/avatar/default-avatar.png"; 
    // if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != '') {
    //     $destination = "./public/avatar/" . basename($_FILES['avatar']['name']);
    //     $origin = $_FILES['avatar']['tmp_name'];

    //     if (FileHelper::fileHandler($origin, $destination)) {
    //         $avatar = $destination; 
    //     }
    // }

    $user = UserRepository::register($username, $password,);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: index.php?c=user');
        exit();
    } else {
        $info = "Error en el registro";
    }
}


if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php?c=user');
    exit();
}

if (isset($_GET['register'])) {
    require_once("views/registerView.phtml");
} else {
    require_once("views/loginView.phtml");
}
