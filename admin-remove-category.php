<?php
	define('LEVEL', 2);
	include_once 'api/auth.php';

	include_once 'api/internal/categories.php';

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		if(count(api_internal_categories_getNumberProductsInCategory($id))>0) return header('Location: admin-list-categories.php?error=La%20categoría%20contiene%20productos.');
		else if(api_internal_categories_removeCategory($id)) return header('Location: admin-list-categories.php?success=Categoría%20fue%20eliminada%20correctamente');
		else return header('Location: admin-list-categories.php?error=La%20categoría%20no%20pudo%eliminarse%20correctamente');
	}
?>