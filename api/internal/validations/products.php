<?php
	include_once("api/connection.php");

	function validations_products_validNewProduct($code, $name, $manufacturer, $catName, $price, $state, $stock, $description){
		$errors = array();
		if(!empty($code) && validations_products_numOcurrrencesCode($code)>0) $errors[] = 'El código ya está tomado';
		if(empty($name)) $errors[] = 'Por favor ingrese un nombre de producto';
		else if(validations_products_numOcurrrencesName($name)>0) $errors[] = 'El nombre del producto ya esta tomado';
		if(empty($manufacturer)) $errors[] = 'Por favor ingrese un fabricante';
		if(empty($catName)) $errors[] = 'Por favor ingrese una categoría';
		if(empty($price)) $errors[] = 'Por favor ingrese un precio';
		if(empty($state)) $errors[] = 'Por favor ingrese un estado';
		else if($state!="Activo" && $state!="Inactivo") $errors[] = 'Por favor ingrese un estado válido';
		if(empty($stock)) $errors[] = 'Por favor ingrese un número de stock';
		return $errors;
	}

	function validations_products_validModifyProduct($code, $name, $manufacturer, $catName, $price, $state, $stock, $description){
		$errors = array();
		if(!empty($code) && validations_products_numOcurrrencesCode($code)>0) $errors[] = 'El código ya está tomado';
		if(empty($name)) $errors[] = 'Por favor ingrese un nombre de producto';
		else if(validations_products_numOcurrrencesName($name)>0) $errors[] = 'El nombre del producto ya esta tomado';
		if(empty($manufacturer)) $errors[] = 'Por favor ingrese un fabricante';
		if(empty($catName)) $errors[] = 'Por favor ingrese una categoría';
		if(empty($price)) $errors[] = 'Por favor ingrese un precio';
		if(empty($state)) $errors[] = 'Por favor ingrese un estado';
		else if($state!="Activo" && $state!="Inactivo") $errors[] = 'Por favor ingrese un estado válido';
		if(empty($stock)) $errors[] = 'Por favor ingrese un número de stock';


		if(!validations_products_codeBelongsProduct($code, $name)) $errors[] = 'El nombre de producto ya está tomado';
		if(!validations_products_nameBelongsProduct($code, $name)) $errors[] = 'El nombre de producto ya está tomado'; 
		if(strlen($password)!=32 && strlen($password)>0) $errors[] = 'Contraseña inválida';
		if(!validEmail($email)) $errors[] = $email.' no es una dirección de correo válida';
		if(!validations_users_emailBelongsUser($id, $email)) $errors[] = 'La direccion de correo esta en uso';
		if(empty($name)) $errors[] = 'Por favor, ingrese un nombre';
		if(empty($lastname)) $errors[] = 'Por favor, ingrese un apellido';
		if(empty($dni)) $errors[] = 'Por favor, ingrese un dni';
		if(empty($direction)) $errors[] = 'Por favor, ingrese una direccion';
		if(empty($role)) $errors[] = 'Por favor, ingrese un rol de usuario';
		return $errors;
	}



	///////////////////////////////
	function validations_products_codeBelongsProduct($code, $name){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `code` FROM `products` WHERE '".$name."'=`name`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return count($rows)==0 || $rows[0]['code']==$code;
			}
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function validations_products_numOcurrrencesCode($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `code` FROM `products` WHERE '".$code."'=`code`";
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

	function validations_products_numOcurrrencesName($name){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `name` FROM `products` WHERE '".$name."'=`name`";
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
	function validations_users_usernameBelongsUser($id, $username){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `users` WHERE '".$username."'=`username`";
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

	function validations_users_emailBelongsUser($id, $email){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `users` WHERE '".$email."'=`email`";
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

	function validEmail($email){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 			return false;
		}
		return true;
	}
?>