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

	
	function api_internal_categories_modifyCategory($id, $code, $name, $description){
		$errors = validations_categories_validModifyCategory($id, $code, $name, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `categories` SET `code`='".$code."',`name`='".$name."',`description`='".$description."' WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar la categoría");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_categories_getCategoryData($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `code`, `name`, `description` FROM `categories` WHERE `id`='".$id."'";
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

	function api_internal_categories_removeCategory($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "DELETE FROM `categories` WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo borrar la categoría");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_categories_getNumberProductsInCategory($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id` FROM `categories` AS C, `products` AS P WHERE '".$id."' = P.`category_id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

?>