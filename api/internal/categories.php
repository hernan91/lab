<?php
	include_once 'api/connection.php';

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
			throw new Exception("No existen usuarios.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

?>