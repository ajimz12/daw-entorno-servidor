<?php
require_once("models/ProductRepository.php");


if (isset($_GET['showUniqueProduct'])) {
    $product = ProductRepository::getProductById($_GET['product_id']);
    require_once("views/ProductView.phtml");
    die();
}