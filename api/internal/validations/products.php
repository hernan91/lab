<?php
	include_once("api/connection.php");

	function validations_products_validNewProduct($code, $name, $price, $name, $lastname, $dni, $direction, $role){
		$errors = array();
		if(strlen($username)<6) $errors[] = 'El nombre de usuario debe tener al menos 6 caracteres';
		if(validations_users_numOcurrrencesUser($username)>0) $errors[] = 'El nombre de usuario ya está tomado'; 
		if(strlen($password)!=32) $errors[] = 'Contraseña inválida';
		if(!validEmail($email)) $errors[] = $email.' no es una dirección de correo válida';
		if(validations_users_numOcurrrencesEmail($email)>0) $errors[] = 'La direccion de correo esta en uso';
		if(empty($name)) $errors[] = 'Por favor, ingrese un nombre';
		if(empty($lastname)) $errors[] = 'Por favor, ingrese un apellido';
		if(empty($dni)) $errors[] = 'Por favor, ingrese un dni';
		if(empty($direction)) $errors[] = 'Por favor, ingrese una direccion';
		if(empty($role)) $errors[] = 'Por favor, ingrese un rol de usuario';
		return $errors;
	}

	function validations_users_validModifyUser($id, $username, $password, $email, $name, $lastname, $dni, $direction, $role){
		$errors = array();
		if(strlen($username)<6) $errors[] = 'El nombre de usuario debe tener al menos 6 caracteres';
		if(!validations_users_usernameBelongsUser($id, $username)) $errors[] = 'El nombre de usuario ya está tomado'; 
		if(strlen($password)!=32 && strlen($password)>0) $errors[] = 'Contraseña inválida';
		if(!validEmail($email)) $errors[] = $email.' no es una dirección de correo válida';
		if(!validations_users_emailBelongsUser($id, $email)) $errors[] = 'La direccion de correo esta en uso';
		if(empty($name)) $errors[] = 'Por favor, ingrese un nombre';
		if(empty($lastname)) $errors[] = 'Por favor, ingrese un apellido';
		if(empty($dni)) $errors[] = 'Por favor, ingrese un dni';
		if(empty($direction)) $errors[] = 'Por favor, ingrese una direccion';
		if(empty($role)) $errors[] = 'Por favor, ingrese un rol de usuario';
		return $errors;s
	}



	///////////////////////////////
	function validations_users_numOcurrrencesUser($username){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `users` WHERE '".$username."'=`username`";
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

	function validations_users_numOcurrrencesEmail($email){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id` FROM `users` WHERE '".$email."'=`email`";
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