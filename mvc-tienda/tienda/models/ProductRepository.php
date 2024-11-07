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

	public static function addProduct($product)
	{
		$db = Connect::connection();

		$imageName = "";
		if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
			$imageName = $_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], "./public/img/" . $imageName);
		}

		$query = "INSERT INTO products (name, description, image, stock, price) VALUES (
        '" . $product->getName() . "',
        '" . $product->getDescription() . "',
        '" . $imageName . "',
        '" . $product->getStock() . "',
        '" . $product->getPrice() . "'
    )";

		$db->query($query);
		header("Location: index.php");
	}

	public static function deleteProduct($id)
	{
		$db = Connect::connection();
		$db->query("DELETE FROM products WHERE product_id = " . $id);
	}

	public static function updateProductStock($productId, $stock)
	{
		$db = Connect::connection();
		$db->query("UPDATE products SET stock = stock - " . $stock . " WHERE product_id = " . $productId);
	}
}
