<?php
	include_once'api/connection.php';
	
	function api_internal_products_newProduct($code, $name, $price, $catName, $manufacturer, $state, $stock ){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, P.`description`, P.`manufacturer`, P.`price`, P.`videoExtension`, P.`state`, P.`stock`, C.`name` as catName FROM `products` AS P,`category` AS C WHERE P.`code`='".$code."' AND P.`category_code`=C.`code`";
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
			$query = "SELECT P.`code`, P.`name`, P.`description`, P.`manufacturer`, P.`price`, P.`videoExtension`, P.`state`, P.`stock`, C.`name` as catName FROM `products` AS P,`category` AS C WHERE P.`code`='".$code."' AND P.`category_code`=C.`code`";
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

	function api_internal_products_getAllCategoriesNames(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `name` FROM `category`";
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
	
?>