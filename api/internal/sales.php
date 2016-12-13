<?php
	
	include_once 'api/connection.php';
	
	//Trae datos de productos del carrito (no vendidos) correspondientes a un usuario
	function api_internal_sales_getAllProductsSalesHistoric($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT S.`id`, P.`id`, P.`code`, P.`name`, P.`price`, P.`manufacturer`, B.`quantity`, S.`date` FROM `products` AS P, `bills` AS B, `sales` AS S WHERE P.`id` = B.`id_product` AND S.`id` = B.`id_sale` AND S.`id_user` = '15' AND S.`selled` = '.$userId.'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_getAllProductsSalesInCart($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT S.`id`, P.`id`, P.`code`, P.`name`, P.`price`, P.`manufacturer`, B.`quantity` FROM `products` AS P, `bills` AS B, `sales` AS S WHERE P.`id` = B.`id_product` AND S.`id` = B.`id_sale` AND S.`id_user` = '.$userId.' AND S.`selled` = '0'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_cartExists($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `sales` WHERE `selled`=0 AND `id_user`='.$userId.'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return count($rows)==1;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_productExistsInCart($productId, $userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT B.`id_product` FROM `bills` AS B, `sales` AS S WHERE S.`id_user`='.$userId.' AND B.`id_product`='.$productId.' AND S.`selled`=0 AND S.`id`=B.`id_sale`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return count($rows)==1;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_modifyQuantityBill($productId, $quantity, $userId){
		$errors = validations_products_validModifyProduct($id, $code, $name, $manufacturer, $category_id, $price, $state, $stock, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `products` SET `code`='".$code."',`name`='".$name."', `manufacturer`='".$manufacturer."', `category_id`='".$category_id."',`price`='".$price."',`state`='".$state."',`stock`='".$stock."',`description`='".$description."' WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");	
	}

	function api_internal_sales_AddToCart($userId, $productId, $quantity){
		if(api_internal_sales_cartExists($userId)){
			if(api_internal_sales_productExistsInCart($productId, $userId)){
				
			}
		}
	}
?>