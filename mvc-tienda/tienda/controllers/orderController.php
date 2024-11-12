<?php

require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");

if (isset($_GET['addCart']) && isset($_SESSION['user'])) {
    $order = OrderRepository::getOrderByUserId($_SESSION['user']->getId());

    if (!$order || $order->getStatus() === 'Confirmado') {
        $newOrderId = OrderRepository::createEmptyOrder($_SESSION['user']->getId());
        $order = OrderRepository::getOrderById($newOrderId);
    }

    $orderLines = OrderLineRepository::getOrderLinesByOrderId($order->getId());
    $productExists = false;


    foreach ($orderLines as $orderLine) {
        if ($orderLine->getProductId() == $_GET['product_id']) {
            $orderLine->setAmount($orderLine->getAmount() + 1);
            OrderLineRepository::updateOrderLineAmount($orderLine, $orderLine->getAmount());
            $productExists = true;
            header("Location: index.php");
            exit();
        }
    }

    if (!$productExists) {
        $orderLine = new OrderLine([
            'order_line_id' => null,
            'order_id' => $order->getId(),
            'product_id' => $_GET['product_id'],
            'amount' => 1,
            'unitary_price' => $_GET['unitary_price'],
        ]);

        OrderLineRepository::addOrderLine($orderLine);
    }

    $orders = OrderRepository::getAllOrdersByUserId($_SESSION['user']->getId());
    require_once("views/CartView.phtml");
}

if (isset($_GET['cart'])) {
    $orders = OrderRepository::getAllOrdersByUserId($_SESSION['user']->getId());
    require_once("views/CartView.phtml");
    exit();
}

if (isset($_GET['payOrder'])) {
    require_once("views/PaymentView.phtml");
    exit();
}

if (isset($_POST['payOrder'])) {
    $order = OrderRepository::getOrderByUserId($_SESSION['user']->getId());
    OrderRepository::updateOrderStatus($order->getId(), 'Confirmado');

    foreach ($order->getAllOrderLines() as $orderLine) {
        ProductRepository::updateProductStock($orderLine->getProductId(), $orderLine->getAmount());
    }
    header('Location: index.php');
    exit();
}

if (isset($_GET['deleteOrderLine'])) {
    OrderLineRepository::deleteOrderLine(orderLineId: $_GET['order_line_id']);
    header('Location: index.php');
    exit();
}
