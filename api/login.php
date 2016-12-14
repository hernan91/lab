<?php
	include 'connection.php';

	function isValidUser($username, $password){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`,`username`,`dni`,`email`,`name`,`lastname`,`direction`, `phone`, `role` FROM `users` WHERE `username`='".$username."' AND `password`='".$password."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return isset($rows[0])?$rows[0]:null;
			}
			throw new Exception("No existen usuarios.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}
	
	function handleLogin($username, $password){
		$userData = isValidUser($username, $password);
		$errors = array();
		if(!isset($userData)){
			$errors[] = "Nombre de usuario o contraseña inválidos";
			return $errors;
		}
		session_start();
		$_SESSION['logged'] = 1;
		$_SESSION['id'] = $userData['id'];
		$_SESSION['name'] = $userData['name'];
		$_SESSION['level'] = $userData['role']=='Administrador'?2:1;
	}
?>