<?php
	include_once 'api/connection.php';
	include_once 'api/internal/validations/products.php';
	
	function api_internal_products_newProduct($code, $name, $manufacturer, $category_id, $price, $state, $stock, $description){
		$errors = validations_products_validNewProduct($code, $name, $manufacturer, $category_id, $price, $state, $stock, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			if(empty($code)) $query = "INSERT INTO `products`(`name`, `manufacturer`, `category_id`, `price`, `state`, `stock`, `description`) VALUES ('".$name."', '".$manufacturer."', '".$category_id."', '".$price."', '".$state."', '".$stock."', '".$description."')";
			else $query = "INSERT INTO `products`(`code`, `name`, `manufacturer`, `category_id`, `price`, `state`, `stock`, `description`) VALUES ('".$code."', '".$name."', '".$manufacturer."', '".$category_id."', '".$price."', '".$state."', '".$stock."', '".$description."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_modifyProduct($id, $code, $name, $manufacturer, $category_id, $price, $state, $stock, $description){
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

	function api_internal_products_removeProduct($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "DELETE FROM `products` WHERE `code`='".$code."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo borrar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllProductsBasicData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`category` AS C WHERE P.`category_code`=C.`code`";
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

	function api_internal_products_getAllProductData($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`description`, P.`manufacturer`, P.`price`, P.`videoExtension`, P.`state`, P.`stock`, C.`name` as catName FROM `products` AS P,`category` AS C WHERE P.`code`='".$code."' AND P.`category_id`=C.`id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0];
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}
	function api_internal_products_getAllProductsBasicTableData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`category` AS C WHERE P.`category_id`=C.`id`";
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

	function api_internal_products_getAllProductBasicData($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `code`, `name`, `manufacturer`, `category_id`, `price`, `state`, `stock`, `description` FROM `products` WHERE `code`='".$code."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0];
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getProductImagesData($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `extension` FROM `images` WHERE `product_id`='".$id."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen imagenes o no existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllProductsByCategory(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, C.`name`, P.`description`, P.`manufacturer`, P.`price`, P.`videoExtension`, P.`state` FROM `products` AS P, `category` AS C WHERE P.`category_code`= C.`code`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getFirstImg(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, C.`name`, P.`description`, P.`manufacturer`, P.`price`, P.`videoExtension`, P.`state` FROM `products` AS P, `category` AS C WHERE P.`category_code`= C.`code`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getAllCategoriesData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`,`name` FROM `category`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen categorías");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

?>