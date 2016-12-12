<?php
	if(isset($_GET['imageFileRemoveId'])){
		$file = $_GET['imageFileRemoveId'];
		if(unlink($file)) return header("Location: ?code=".$code."&success=Imagen%20borrada%20correctamente");
		else return header("Location: ?error=Hubo%20un%20error%20al%borrar%20la%20imagen&code=".$code);
	}
?>