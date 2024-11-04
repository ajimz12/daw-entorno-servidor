<?php

class OrderLineRepository
{

    public static function addOrderLine($order_line)
    {
        $db = Connect::connection();
        $query = "INSERT INTO order_lines (order_id, product_id, quantity) VALUES (" . $order_line->getOrderId() . ", " . $order_line->getProductId() . ", " . $order_line->getQuantity() . ")";
        $db->query($query);
    }

    public static function getOrderLinesByOrderId($order_id)
    {
        $db = Connect::connection();
        $result = $db->query("SELECT * FROM order_lines WHERE order_id = " . $order_id);
        $orderLines = [];
        while ($row = $result->fetch_assoc()) {
            $orderLines[] = new OrderLine($row);
        }
        return $orderLines;
    }
}
