<?php
require_once('models/User.php');
require_once('models/Product.php');
require_once('models/UserRepository.php');
require_once('models/ProductRepository.php');

session_start();

if (isset($_GET['c']) && $_GET['c'] === 'login') {
    require_once("controllers/userController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'register') {
    require_once("controllers/userController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'product') {
    require_once("controllers/productController.php");
    exit();
}

if (isset($_GET['c']) && $_GET['c'] === 'cart') {
    require_once("controllers/cartController.php");
    exit();
}

if (isset($_POST['search'])) {
    $products = ProductRepository::getProductByName($_POST['search']);
} else {
    $products = ProductRepository::getProducts();
}

require_once('views/MainView.phtml');
