<?php

require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");

if (isset($_GET['addCart']) && isset($_SESSION['user'])) {
    $order = OrderRepository::getOrderByUserId($_SESSION['user']->getUserId());

    if ($order) {
        $orderLine = new OrderLine([
            'order_line_id' => null,
            'order_id' => $order->getOrderId(),
            'product_id' => $_GET['product_id'],
            'amount' => 1,
            'unitary_price' => $_GET['unitary_price'],
        ]);

        OrderLineRepository::addOrderLine($orderLine);
    }
}

if (isset($_GET['cart'])) {
    $orders = OrderRepository::getAllOrders();
}

require_once("views/CartView.phtml");
