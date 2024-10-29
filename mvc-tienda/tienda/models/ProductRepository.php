<?php

class ProductRepository
{
    public static function getProducts()
    {
        $db = Connect::connection();
        $products = array();
        $result = $db->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row);
        }
        return $products;
    }

    public static function getProductByName($name)
	{
		$db = Connect::connection();
		$products = array();
		$result = $db->query("SELECT * FROM products WHERE name LIKE '%" . $name . "%'");
		while ($row = $result->fetch_assoc()) {
			$products[] = new Product($row);
		}
		return $products;
	}
}
