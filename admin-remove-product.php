<?php
	include_once 'api/internal/products.php';

	if(isset($_GET['code'])){
		$code = $_GET['code'];
		$name = api_internal_products_getAllProductsBasicTableData($code)['name'];
		if(api_internal_products_removeProduct($code)){
			header('Location: admin-list-products.php?success=Producto%20<b>'.$name.'</b>%20eliminado%20correctamente');
			die();
		}
		else{
			header('Location: admin-list-products.php?error=El%20producto%20<b>'.$name.'</b>%20no%20pudo%eliminarse%20correctamente');
			die();
		}
	}
?>