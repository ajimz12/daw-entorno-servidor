<?php

require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");

if (isset($_GET['addCart']) && isset($_SESSION['user'])) {
    $order = OrderRepository::getOrderByUserId($_SESSION['user']->getUserId());
    $orderLines = OrderLineRepository::getOrderLinesByOrderId($order->getOrderId());

    foreach ($orderLines as $orderLine) {
        if ($orderLine->getProductId() == $_GET['product_id']) {
            $orderLine->setAmount($orderLine->getAmount() + 1);
            OrderLineRepository::updateOrderLineAmount($orderLine, $orderLine->getAmount());
            header("Location: index.php");
            exit();
        }
    }

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
    $orders = OrderRepository::getAllOrdersByUserId($_SESSION['user']->getUserId());
    require_once("views/CartView.phtml");
}

if (isset($_GET['cart'])) {
    $orders = OrderRepository::getAllOrdersByUserId($_SESSION['user']->getUserId());
    require_once("views/CartView.phtml");
}
