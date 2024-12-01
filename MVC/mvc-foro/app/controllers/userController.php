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
            $info = "Error en el login";
        }
    }
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $active = 1;
    $role = "normal";

    $avatar = "";
    if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != '') {
        $avatar = "./public/avatar/" . $_FILES['avatar']['name'];
        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
    } else {
        $avatar = "./public/avatar/default-avatar.png";
    }

    $user = UserRepository::register($username, $email, $password,  $avatar, $role, $active);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: index.php?c=login');
        exit();
    } else {
        $info = "Error en el registro";
    }
}

if (isset($_GET['banUser'])) {
    $userId = $_GET['user_id'];
    UserRepository::banUser($userId);
    header("Location: index.php?c=user&showUsers=1");
    exit();
}


if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php?c=login');
    exit();
}

if (isset($_GET['register'])) {
    require_once("views/registerView.phtml");
} else if (isset($_GET['showUsers'])) {
    $users = UserRepository::getAllUsers();
    require_once("views/usersView.phtml");
    exit();
} else {
    require_once("views/loginView.phtml");
}
