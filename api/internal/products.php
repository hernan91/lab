<?php
	include_once 'api/connection.php';
	include_once 'api/internal/validations/products.php';
	
	function api_internal_products_newProduct($code, $name, $manufacturer, $category_code, $price, $state, $stock, $description){
		$errors = validations_products_validNewProduct($code, $name, $manufacturer, $category_code, $price, $state, $stock, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			if(empty($code)) $query = "INSERT INTO `products`(`name`, `manufacturer`, `category_code`, `price`, `state`, `stock`, `description`) VALUES ('".$name."', '".$manufacturer."', '".$category_code."', '".$price."', '".$state."', '".$stock."', '".$description."')";
			else $query = "INSERT INTO `products`(`code`, `name`, `manufacturer`, `category_code`, `price`, `state`, `stock`, `description`) VALUES ('".$code."', '".$name."', '".$manufacturer."', '".$category_code."', '".$price."', '".$state."', '".$stock."', '".$description."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllProductsBasicTableData(){
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

	function api_internal_products_getAllProductBasicData($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `code`, `name`, `manufacturer`, `category_code`, `price`, `state`, `stock`, `description` FROM `products` WHERE `code`='".$code."'";
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

	function api_internal_products_getProductImagesData($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `extension` FROM `images` WHERE `id_product`='".$code."'";
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
			$query = "SELECT `code`,`name` FROM `category`";
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