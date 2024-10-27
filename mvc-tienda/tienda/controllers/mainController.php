<?php

require_once('models/User.php');
require_once('models/UserRepository.php');

session_start();

if (isset($_GET['c'])) {
    if (isset($_GET['c']) == 'user') {
        require_once("controllers/userController.php");
        header('Location: index.php');
    }
}
