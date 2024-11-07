<?php
require_once('models/User.php');
require_once('models/Product.php');
require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once('models/UserRepository.php');
require_once('models/ProductRepository.php');
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");

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
    require_once("controllers/orderController.php");
    exit();
}

if (isset($_POST['search'])) {
    $products = ProductRepository::getProductByName($_POST['search']);
} else {
    $products = ProductRepository::getProducts();
}

if (isset($_GET['deleteProduct'])) {
    ProductRepository::deleteProduct($_GET['id']);
    header('Location: index.php');
}

if (isset($_GET['deleteOrderLine'])) {
    OrderLineRepository::deleteOrderLine(orderLineId: $_GET['order_line_id']);
    header('Location: index.php');
}

if (isset($_GET['payOrder'])) {
    $order = OrderRepository::getOrderByUserId($_SESSION['user']->getUserId());
    OrderRepository::updateOrderStatus($order->getOrderId(), 'Pagado');

    foreach ($order->getAllOrderLines() as $orderLine) {
        ProductRepository::updateProductStock($orderLine->getProductId(), $orderLine->getAmount());
    }
    header('Location: index.php');
}

require_once('views/MainView.phtml');
