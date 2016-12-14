<?php
	session_start();
	$adminArray = array("admin-add-category", "admin-add-product", "admin-add-user", "admin-detail-product", "admin-edit-category", "admin-edit-files", "admin-edit-product", "admin-edit-user", "admin-remove-category", "admin-remove-product", "admin-remove-user");
	if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1 ) return header('Location: login.php?error="Auntentifíquese para ingresar"');
	else if(LEVEL>$_SESSION['level']) return header('Location: login.php?error="Esta sección es solo para administradores"');
?>