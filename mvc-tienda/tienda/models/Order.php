<?php

class Order
{
    private $order_id;
    private $user_id;
    private $order_date;
    private $total;
    private $status;
    private $order_lines = [];


    public function __construct($data)
    {
        $this->order_id = $data['order_id'];
        $this->user_id = $data['user_id'];
        $this->order_date = $data['order_date'];
        $this->total = $data['total'];
        $this->status = $data['status'];
        $this->order_lines = OrderLineRepository::getOrderLinesByOrderId($this->order_id);
    }

    public function getId()
    {
        return $this->order_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getOrderDate()
    {
        return $this->order_date;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getAllOrderLines()
    {
        return $this->order_lines;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }
}
