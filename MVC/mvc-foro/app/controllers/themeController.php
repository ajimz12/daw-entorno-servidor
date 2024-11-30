<?php

require_once("./models/Theme.php");
require_once("./models/ThemeRepository.php");

if (isset($_POST['addTheme'])) {
    $themeTitle = $_POST['themeTitle'];
    $themeContent = $_POST['themeContent'];

    $themeImage = "";
    if (isset($_FILES['themeImage']['name']) && $_FILES['themeImage']['name'] != '') {
        $uploadDir = "./public/theme-img/";
        $uploadedFile = $uploadDir . basename($_FILES['themeImage']['name']);
        if (move_uploaded_file($_FILES['themeImage']['tmp_name'], $uploadedFile)) {
            $themeImage = $uploadedFile; 
        } else {
            echo "Error al mover el archivo";
            $themeImage = ""; 
        }
    }


    $data = [
        'title' => $themeTitle,
        'content' => $themeContent,
        'theme_image' => $themeImage,
        'user_id' => $_SESSION['user']->getId(),
        'forum_id' => $_POST['forum_id'],
        'hidden' => 0,
    ];

    $theme = new Theme($data);
    ThemeRepository::addTheme($theme);
}
