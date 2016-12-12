<?php
	include_once("api/connection.php");

	function validations_categories_validNewCategory($code, $name, $description){
		$errors = array();
		if(!empty($code) && validations_categories_numOcurrrencesCode($code)>0) $errors[] = 'El código ya está tomado';
		if(empty($name)) $errors[] = 'Por favor ingrese un nombre de categoría';
		else if(validations_categories_numOcurrrencesCategoryName($name)>0) $errors[] = 'El nombre de la categoría ya esta tomado';
		return $errors;
	}

	function validations_categories_validModifyCategory($id, $code, $name, $description){
		$errors = array();
		if(empty($code)) $errors[] = 'Por favor ingrese un código de producto'; 
		else if(!validations_categories_codeBelongsCategory($id, $code)) $errors[] = 'El código de categoría ya está tomado';
		if(empty($name)) $errors[] = 'Por favor ingrese un nombre de producto';
		else if(!validations_categories_nameBelongsCategory($id, $name)) $errors[] = 'El nombre de categoría ya está tomado';
		return $errors;
	}



	///////////////////////////////
	function validations_categories_nameBelongsCategory($id, $name){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `categories` WHERE '".$name."'=`name`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				//retorna true si no existen usuarios con ese email o existe uno que es el actual
				return count($rows)==0 || $rows[0]['id']==$id;
			}
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function validations_categories_codeBelongsCategory($id, $code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `categories` WHERE '".$code."'=`code`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return count($rows)==0 || $rows[0]['id']==$id;
			}
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function validations_categories_numOcurrrencesCode($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `code` FROM `categories` WHERE '".$code."'=`code`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return count($rows);
			}
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function validations_categories_numOcurrrencesCategoryName($name){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `name` FROM `categories` WHERE '".$name."'=`name`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return count($rows);
			}
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	//si el nombre de usuario pertenece al mismo usuario o no existe entonces esta todo bien
	
?>