<?php

class OrderLine
{
    private $order_line_id;
    private $order_id;
    private $product_id;
    private $amount;
    private $unitary_price;

    function __construct($datos)
    {
        $this->order_line_id = $datos['order_line_id'];
        $this->order_id = $datos['order_id'];
        $this->product_id = $datos['product_id'];
        $this->amount = $datos['amount'];
        $this->unitary_price = $datos['unitary_price'];
    }

    // Getters
    public function getOrderLineId()
    {
        return $this->order_line_id;
    }
    public function getOrderId()
    {
        return $this->order_id;
    }
    public function getProductId()
    {
        return $this->product_id;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getUnitaryPrice()
    {
        return $this->unitary_price;
    }
    public function getTotalPrice()
    {
        return $this->amount * $this->unitary_price;
    }
}
