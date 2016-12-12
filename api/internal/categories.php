<?php
	include_once 'api/connection.php';
	include_once 'api/internal/validations/categories.php';

	function api_internal_categories_getAllCategoriesData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT * FROM `categories`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen categorias");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_categories_newCategory($code, $name, $description){
		$errors = validations_categories_validNewCategory($code, $name, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			$query = "INSERT INTO `categories`(`code`, `name`, `description`) VALUES ('".$code."', '".$name."', '".$description."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar la categoria.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

?>