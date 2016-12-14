<?php
	include_once 'api/internal/users.php';
	define('LEVEL', 2);
	include_once 'api/auth.php';

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$username = api_internal_users_getUserData($id)['username'];
		if(api_internal_users_removeUser($id)){
			header('Location: admin-list-users.php?success=Usuario%20<b>'.$username.'</b>%20eliminado%20correctamente');
			die();
		}
		else{
			header('Location: admin-list-users.php?error=El%20usuario%20<b>'.$username.'</b>%20no%20pudo%eliminarse%20correctamente');
			die();
		}
	}
?>