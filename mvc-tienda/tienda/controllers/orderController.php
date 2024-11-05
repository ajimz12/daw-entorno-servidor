<?php

require_once("models/Order.php");
require_once("models/OrderRepository.php");

session_start();


if (!isset($_SESSION['order_id'])) {
    $order = new Order($_SESSION['user_id']);
    OrderRepository::addOrder($order);


    $data = [$_SESSION['order_id'], $product_id, $quantity, $unit_price];

    $orderLine = new OrderLine($data);
    OrderLineRepository::addOrderLine($orderLine);

    header("Location: index.php");
}

if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
    $orderLines = $orderLineRepository->getOrderLinesByOrderId($order_id);
    require 'views/CartView.phtml';
} else {
    echo "No hay productos en el carrito.";
}
