<?php

class OrderLineRepository
{

    public static function addOrderLine($order_line)
    {
        $db = Connect::connection();
        $query = "INSERT INTO order_line (order_id, product_id, amount, unitary_price) VALUES (" . $order_line->getOrderId() . ", " . $order_line->getProductId() . ", " . $order_line->getAmount() . ", " . $order_line->getUnitaryPrice() .  ")";
        $db->query($query);
    }

    public static function getOrderLinesByOrderId($order_id): array
    {
        $db = Connect::connection();
        $result = $db->query("SELECT * FROM order_line WHERE order_id = " . $order_id);
        $orderLines = [];
        while ($row = $result->fetch_assoc()) {
            $orderLines[] = new OrderLine(datos: $row);
        }
        return $orderLines;
    }

    public static function deleteOrderLine($orderLineId){
        $db = Connect::connection();
        $query = "DELETE FROM order_line WHERE order_line_id = ". $orderLineId;
        $db->query($query);
    }
}
