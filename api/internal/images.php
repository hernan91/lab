<?php
	include_once 'api/connection.php';
	
	function api_internal_images_newImage($product_id, $extension){
		$con = new Conexion();
		if($con->connect()){
			$query = "INSERT INTO `images`(`product_id`, `extension`) VALUES ('".$product_id."', '".$extension."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar la imagen.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_images_removeImage($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "DELETE FROM `images` WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo borrar la imagen");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_images_getImageData($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `product_id`, `extension` FROM `images` WHERE P.`category_code`=C.`code`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_getLastImageId(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT * FROM images ORDER BY id DESC LIMIT 0, 1";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0]['id'];
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
		
	}

?>