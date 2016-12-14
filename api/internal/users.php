<?php
	include_once 'api/connection.php';
	include_once 'api/internal/validations/users.php';

	function api_internal_users_newUploadData($id, $email, $direction, $phone){
		$errors = validations_users_validUploadDataUser($id, $email, $direction, $phone);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `users` SET `email`='".$email."', `direction`='".$direction."', `phone`='".$phone."' WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_users_getUserData($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`,`username`,`dni`,`email`,`name`,`lastname`,`direction`, `phone`, `role` FROM `users` WHERE `id`='".$id."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0];
			}
			throw new Exception("No existen usuarios.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_users_getAllUsersData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`,`username`,`dni`,`email`,`name`,`lastname`,`direction`, `phone`, `role` FROM `users`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen usuarios.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_users_newUser($username, $password, $email, $name, $lastname, $dni, $direction, $phone, $role){
		$errors = validations_users_validNewUser($username, $password, $email, $name, $lastname, $dni, $direction, $phone, $role);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			$query = "INSERT INTO `users`(`username`, `password`, `dni`, `email`, `name`, `lastname`, `direction`, `phone`, `role`) VALUES ('".$username."', '".$password."', '".$dni."', '".$email."', '".$name."', '".$lastname."', '".$direction."', '".$phone."', '".$role."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar el usuario.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_users_modifyUser($id, $username, $password, $email, $name, $lastname, $dni, $direction, $phone, $role){
		$errors = validations_users_validModifyUser($id, $username, $password, $email, $name, $lastname, $dni, $direction, $phone, $role);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			if(!empty($password)) $query = "UPDATE `users` SET `username`='".$username."',`password`='".$password."',`email`='".$email."',`email`='".$email."',`name`='".$name."',`lastname`='".$lastname."',`dni`='".$dni."',`direction`='".$direction."', `phone`='".$phone."', `role`='".$role."' WHERE `id`='".$id."'";
			else $query = "UPDATE `users` SET `username`='".$username."',`email`='".$email."',`name`='".$name."',`lastname`='".$lastname."',`dni`='".$dni."',`direction`='".$direction."', `phone`='".$phone."', `role`='".$role."' WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_users_removeUser($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "DELETE FROM `users` WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo borrar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function dniExists($dni){
		$con = new Conexion();
		$flag = false;
		if($con->connect()){
			$query = "SELECT alu_dni FROM `alumnos` WHERE alu_dni='$dni'";
			if($result = $con->query($query)){
				if($result->fetch_row()>0){
					$flag = true;
				}
			}
		}
		$con->disconnect();
		return $flag;
	}
	
	function deleteAlumn($dni){
		$flag= false;
		if(dniExists($dni)){
			$con = new Conexion();
			if($con->connect()){
				$query = "DELETE FROM `alumnos` WHERE alu_dni='$dni'";
				if($con->query($query)){
					$flag = true;
				}
			}
			$con->disconnect();
		}
		return $flag;
	}
	
	function getAllAlumns(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `alu_nombres`, `alu_apellido`, `alu_dni`, `alu_telefono01` FROM `alumnos`";
			if($result = $con->query($query)){
				return $result;
			}
			$con->disconnect();
		}
		return null;
	}
	function api_usuarios_getAll(){
		$dato1 = array(
		"name" => "Categoria 1",
		"value" => "Categoria 1",
		);
		$dato2 = array(
		"name" => "Categoria 2",
		"value" => "Categoria 2",
		);
		$json = array(
			'success' => true, 
			//'results' => json_encode($dato1)
			'results' => array($dato1, $dato2)
		);
		return $json;
	}
	
?>