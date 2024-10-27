<?php

class Product
{
    private $id;
    private $name;
    private $description;
    private $image;
    private $storage;
    private $price;


    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->image = $data['image'];
        $this->storage = $data['storage'];
        $this->price = $data['price'];
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getStorage()
    {
        return $this->storage;
    }

    public function getPrice()
    {
        return $this->price;
    }

    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setStorage($storage)
    {
        $this->storage = $storage;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}
