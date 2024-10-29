<?php
require_once('models/User.php');
require_once('models/UserRepository.php');

session_start();

if (isset($_GET['c']) && $_GET['c'] === 'login') {
    require_once("controllers/userController.php");
    exit(); 
}

require_once('views/MainView.phtml');
