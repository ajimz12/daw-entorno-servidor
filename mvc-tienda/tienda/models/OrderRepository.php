<?php

class OrderRepository
{
    public static function createEmptyOrder($user_id)
    {
        $db = Connect::connection();
        $query = "INSERT INTO orders (user_id, order_date, total, status) VALUES ('$user_id', NOW(), 0, 'Pendiente')";
        $db->query($query);
        return $db->insert_id;
    }

    public static function addOrder($order)
    {
        $db = Connect::connection();
        $query = "INSERT INTO order (user_id, order_date, total, status) VALUES ('$order->getUserId', '$order->getOrderDate, '$order->getTotal' , '$order->getStatus";
        $db->query($query);
    }

    public static function getAllOrders()
    {
        $db = Connect::connection();
        $orders = array();
        $result = $db->query("SELECT * FROM orders");
        while ($row = $result->fetch_assoc()) {
            $orders[] = new Order($row);
        }
        return $orders;
    }

    public static function getOrderById($orderId)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM orders WHERE id = '$orderId'";
        $result = $db->query($query);
        if ($row = $result->fetch_assoc()) {
            return new Order($row);
        }
        return null;
    }

    public static function getOrderByUserId($user_id)
    {
        $db = Connect::connection();
        $query = "SELECT * FROM orders WHERE user_id = '$user_id' AND status = 'Pendiente' LIMIT 1";
        $result = $db->query($query);

        if ($row = $result->fetch_assoc()) {
            return new Order($row);
        }
        return null;
    }

    public static function updateOrderStatus($orderId, $status)
    {
        $db = Connect::connection();
        $query = "UPDATE orders SET status = '$status' WHERE order_id = '$orderId'";
        $db->query(query: $query);
    }
}
