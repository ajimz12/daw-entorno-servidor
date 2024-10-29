<?php
require_once("models/ProductRepository.php");
require_once("models/Product.php");

if (isset($_GET['addProduct'])) {
    require_once("views/AddProductView.phtml");
}

if (isset($_POST['addProduct'])) {
    $imageName = "";
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $imageName = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "./public/img/" . $imageName);
    }

    $data = [
        'id' => null,
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'image' => $imageName,
        'stock' => $_POST['stock'],
        'price' => $_POST['price']
    ];

    $product = new Product($data);
    ProductRepository::addProduct($product);

    exit();
}

if (isset($_GET['deleteProduct'])) {
    ProductRepository::deleteProduct($_GET['product_id']);
}


if (isset($_GET['showUniqueProduct'])) {
    $product = ProductRepository::getProductById($_GET['product_id']);
    require_once("views/ProductView.phtml");
    die();
}
