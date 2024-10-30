<?php

class OrderLineRepository
{

    public static function addOrderLine($order_line)
    {
        $db = Connect::connection();
        $query = "INSERT INTO order_lines (order_id, product_id, quantity) VALUES (" . $order_line->getOrderId() . ", " . $order_line->getProductId() . ", " . $order_line->getQuantity() . ")";
        $db->query($query);
    }
}
