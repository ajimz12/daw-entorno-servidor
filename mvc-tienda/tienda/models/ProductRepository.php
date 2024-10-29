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

    public static function getProductById($id)
	{
		$db = Connect::connection();
		$result = $db->query("SELECT * FROM products WHERE product_id = " . $id);

		if ($row = $result->fetch_assoc()) {
			return new Product($row);
		}

		return null;
	}
}
