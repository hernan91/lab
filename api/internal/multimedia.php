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

	function api_internal_images_getImageExtension($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `extension` FROM `images` WHERE `id`='".$id."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0]['extension'];
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

	function api_internal_videos_editVideoExtension($product_id, $extension){
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `products` SET `videoExtension`='".$extension."' WHERE `id`='".$product_id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar la imagen.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_videos_removeVideoExtension($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `products` SET `videoExtension`='' WHERE `code`='".$code."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar la imagen.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

?>