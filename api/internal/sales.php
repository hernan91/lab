<?php
	
	include_once 'api/connection.php';
	include_once 'api/internal/mail.php';
	
	function api_internal_sales_getAllFinishedProductsBillsByUser($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT S.`id` AS sale_id, P.`id` AS product_id, P.`code` as product_code, P.`name` as product_name, P.`price` as product_price, P.`manufacturer` as product_manufacturer, B.`quantity` as quantity, S.`date` as date FROM `products` AS P, `bills` AS B, `sales` AS S WHERE P.`id` = B.`id_product` AND S.`id` = B.`id_sale` AND S.`id_user` = '15' AND S.`selled` = '0'";
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

	function api_internal_sales_getAllUnfinishedProductsBillsByUser($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT S.`id` AS sale_id, P.`id` AS product_id, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity FROM `products` AS P, `bills` AS B, `sales` AS S WHERE P.`id` = B.`id_product` AND S.`id` = B.`id_sale` AND S.`id_user` = '15' AND S.`selled` = '0'";
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

	function api_internal_sales_unfinishedSaleExists($userId){
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

	function api_internal_sales_productExistsInBills($productId, $userId){
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

	function api_internal_sales_getProductBillQuantity($productId, $saleId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `quantity` FROM `bills` WHERE `id_sale`='$saleId' AND `id_product`='$productId'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				if(isset($rows[0])) return $rows[0]['quantity']; 
				return false;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_modifyQuantityBill($productId, $quantity, $saleId){
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `bills` SET `quantity`='".$quantity."' WHERE `id_sale`='".$saleId."' AND `id_product`='".$productId."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");	
	}

	//obtiene el sale_id de el carrito que pertenece a un usuario
	function api_internal_sales_getUnfinishedSaleId($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `sales` WHERE `id_user`='.$userId.' AND `selled`=0";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				if(isset($rows[0])) return $rows[0]['id']; 
				return false;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_newUnfinishedSale($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "INSERT INTO `sales`(`user_id`, `selled`) VALUES ('".$userId."', '0')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_newProductInBills($productId, $saleId, $quantity){
		$con = new Conexion();
		if($con->connect()){
			$query = "INSERT INTO `bills`(`id_sale`, `id_product`, `quantity`) VALUES ('".$saleId."', '".$productId."', '".$quantity."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_removeProductFormBill($productId, $saleId){
		$con = new Conexion();
		if($con->connect()){
			$query = "DELETE FROM `bills` WHERE `id_product`='".$productId."' AND `id_sale`='".$saleId."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo remover el producto del carrito");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_sales_setFinishedSale($saleId){
		$con = new Conexion();
		if($con->connect()){
			$date = date('Y-m-d H:i:s');
			$query = "UPDATE `sales` SET `selled`='1', `date`='".$date."' WHERE `id_sale`='".$saleId."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	//va en users pero para ahorrar includes
	function api_internal_users_getEmail($userId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `email` FROM `users`WHERE `id`='.$userId.'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				if(isset($rows[0])) return $rows[0]['email']; 
				return false;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}



	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//si hay un error, retorna un array de errores
	function api_internal_sales_AddToCart($userId, $productId, $quantity){
		$error = "";
		if(!api_internal_sales_unfinishedSaleExists($userId)){
			if(!api_internal_sales_newUnfinishedSale($userId)) return $error = "No se pudo completar la operación";
		}
		$saleId = api_internal_sales_getUnfinishedSaleId($userId);
		if($saleId==false) return $error = "No se pudo completar la operación";
		if(!api_internal_sales_productExistsInBills($productId, $userId)){
			if(!api_internal_sales_newProductInBills($productId, $saleId, $quantity)) return $error = "No se pudo completar la operación";
		}
		else{
			$actualQuantity = api_internal_sales_getProductBillQuantity($productId, $saleId);
			if($actualQuantity==false) return $error = "No se pudo completar la operación";
			$newQuantity = $actualQuantity + $quantity;
			if(!api_internal_sales_modifyQuantityBill($productId, $newQuantity, $saleId)) return $error = "No se pudo completar la operación";	
		}
		return true;
	}

	function api_internal_sales_RemoveProductFromCart($userId, $productId){
		$error = "";
		if(!api_internal_sales_unfinishedSaleExists($userId)) return $error = "No se pudo completar la operación";
		$saleId = api_internal_sales_getUnfinishedSaleId($userId);
		if($saleId==false) return $error = "No se pudo completar la operación";
		if(!api_internal_sales_productExistsInBills($productId, $userId)) return $error = "No se pudo completar la operación";
		if(!api_internal_sales_removeProductFormBill($productId, $saleId)) return $error = "No se pudo completar la operación";
		return true;
	}

	function api_internal_sales_finishSale($userId){
		$error = arrray();
		if(!api_internal_sales_unfinishedSaleExists($userId)) return $error = "No se pudo completar la operación";
		$listOfUnfinishedBills = api_internal_sales_getAllUnfinishedProductsBillsByUser($userId);
		$saleId = $bill['sale_id'];
		
		foreach($listOfUnfinishedBills as $bill){
			$productStock = api_internal_products_getProductStock($bill['product_id']);
			if($bill['quantity']>$productStock) return $error = "No existe stock suficiente para comprar ".$bill['product_name']; 
			$newStock = $productStock-$bill['quantity'];	
			if(!api_internal_sales_productExistsInBills($productId, $userId)) return $error = "No existe el producto en el carrito de compras";
			if(!api_internal_product_updateProductStock($productId, $newStock)) return $error = "Se finalizo la compra pero no se pudo actualizar el stock del producto";
		}

		if(!api_internal_sales_setFinishedSale($saleId)) return $error = "No se pudo finalizar la compra";
		$userEmail = api_internal_users_getEmail($userId);
		if(!api_internal_mail_sendMail($userEmail)) return $error ="Se finalizo la compra pero no se mando el mail";

		if(!api_internal_sales_newUnfinishedSale($userId)) return $error = "Se finalizo la compra y se mando el mail pero no se creo nuevamente un carrito";
		return true;
	}
?>