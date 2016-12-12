<?php define('PAGE', "admin-detail-products") ?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/products.php");
	include_once 'components/modalConfirm.php';
	include_once("api/internal/multimedia.php");
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea subir esta imágen?", "modalConfirmacionSubirImagen");
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea borrar esta imágen?", "modalConfirmacionBorrarImagen");
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea subir este video?", "modalConfirmacionSubirVideo");
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea borrar este video?", "modalConfirmacionBorrarVideo");
?>
<?php
	$success = isset($_GET['success']);
	$error = isset($_GET['error']);
	if(isset($_GET['code'])){
		$productCode = $_GET['code'];
		$productData = api_internal_products_getAllProductData($productCode);
		$productImagesData = api_internal_products_getProductImagesData($productData['id']);
	}
	if(isset($_POST['product_id'])){
		if(isset($_FILES['imageFile'])){
			$product_id = $_POST['product_id'];
			$imageFileType = pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION);
			api_internal_images_newImage($product_id, $imageFileType);
			$image_id = api_internal_getLastImageId();
			$file = 'data/img/products/'.$image_id.'.'.$imageFileType;
			
			// es una imagen?
			if(!getimagesize($_FILES["imageFile"]["tmp_name"])){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=El%20archivo%20no%20es%20una%20imágen&code=".$productCode);
			}
			
			// existe la imagen?
			if (file_exists($file)){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Ya%20existe%20la%20imágen&code=".$productCode);
			} 
			
			// tamaño
			if ($_FILES["imageFile"]["size"] > 500000){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Archivo%20demasiado%20grande%20&code=".$productCode);
			}
			
			// Formatos
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "gif" ){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Formato%20incorrecto.%20Solo%20jpeg,jpg,png%20y%20gif.&code=".$productCode);
			}
			
			// Check if $uploadOk is set to true by an error
				/*api_internal_images_removeImage($image_id);
				header("Location: ?error=Hubo%20un%20error%20al%20subir%20la%20imagen");*/

			if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $file)) {
				return header("Location: ?code=".$productCode."&success=Imagen%20subida%20correctamente");
			} else {
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Hubo%20un%20error%20al%20subir%20la%20imagen&code=".$productCode);
			}
		}
		if(isset($_FILES['videoFile'])){
			$product_id = $_POST['product_id'];
			$videoFileType = pathinfo($_FILES["videoFile"]["name"], PATHINFO_EXTENSION);
			$file = 'data/video/products/'.$product_id.'.'.$videoFileType;
			
			if(!filesize($_FILES["videoFile"]["tmp_name"]))	return header("Location: ?error=El%20archivo%20no%20es%20una%20imágen&code=".$productCode);
			//if (file_exists($file))	return header("Location: ?error=Ya%20existe%20la%20imágen&code=".$productCode);
			if ($_FILES["videoFile"]["size"] > 50000000) return header("Location: ?error=Archivo%20demasiado%20grande%20&code=".$productCode);
			if($videoFileType != "mp4" && $videoFileType != "ogg") return header("Location: ?error=Formato%20incorrecto.%20Solo%20mp4y%20ogg.&code=".$productCode);
			if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $file)){
				api_internal_videos_editVideoExtension($product_id, $videoFileType);
				return header("Location: ?code=".$productCode."&success=Video%20subido%20correctamente");
			} 
			else return header("Location: ?error=Hubo%20un%20error%20al%20subir%20el%20video&code=".$productCode);
		}
	}
	if(isset($_GET['imageFileRemoveId'])){
		$imageFileRemoveId = $_GET['imageFileRemoveId'];
		$imageFileExtension = api_internal_images_getImageExtension($imageFileRemoveId);
		$file = "data/img/products/".$imageFileRemoveId.".".$imageFileExtension;
		if(unlink($file)){
			api_internal_images_removeImage($imageFileRemoveId);
			return header("Location: ?code=".$productCode."&success=Imagen%20borrada%20correctamente");
		}
		else return header("Location: ?error=Hubo%20un%20error%20al%borrar%20la%20imagen&code=".$productCode);
	}
	if(isset($_GET['videoRemoveProductId'])){  //videoFileRemoveProductId
		$productId = $_GET['videoRemoveProductId'];
		$videoExtension = $_GET['videoExtension'];
		$file = "data/video/products/".$productId.".".$videoExtension;
		if(unlink($file)){
			api_internal_videos_removeVideoExtension($productCode);
			return header("Location: ?code=".$productCode."&success=Video%20borrado%20correctamente");
		}
		else return header("Location: ?error=Hubo%20un%20error%20al%borrar%20el%20video&code=".$productCode);
	}
	

?>

<div class="ui <?php echo $success?"":"hidden" ?> success message">
	<i class="close icon"></i>
	<div class="header">Operacion completada correctamente</div>
	<p><?php echo $success?$_GET['success']:""?></p>
</div>

<div class="ui <?php echo $error?"":"hidden" ?> error message">
	<i class="close icon"></i>
	<div class="header">Surgió un error al realizar la operación</div>
	<p><?php echo $error?$_GET['error']:""?></p>
</div>

<div class="ui <?php echo (isset($productData))?'hidden':''?> warning message">
	<div class="header">Advertencia</div>
	No existe el producto solicitado
</div>

<div class="ui segment <?php echo (isset($productData))?'hidden':''?> ">
	<h3 class="ui dividing header"><b>Contenido multimedia del producto seleccionado</b></h3>
	<div class="ui grid"> <!--internally celled-->
		<div class="ten wide column">
			<div class="ui segment">
				<div class="ui small images">
					<?php
							/*<div class="ui special cards">
								<div class="card">
									<div class="blurring dimmable image">
									<div class="ui dimmer">
										<div class="content">
										<div class="center">
											<div class="ui inverted button">Add Friend</div>
										</div>
										</div>
									</div>
									<img src="/images/avatar/large/elliot.jpg">
									</div>
								</div>
							</div>*/
						if(count($productImagesData)==0) echo '<h3>No existen imágenes para mostrar</h3>';
						foreach($productImagesData as $imageData){
							echo '
								<div class="ui bordered image">
									<i data-code="'.$productCode.'" data-idimg="'.$imageData['id'].'" id="imgRemove" class="remove icon"></i>
									<img src="data/img/products/'.$imageData['id'].".".$imageData['extension'].'">
								</div>
								';
						}
					?>
				</div>
				
				<form id="imageForm" class="ui form" action="" method="post" enctype="multipart/form-data">
					<div class="ui dividing header"></div>
					<div class="ui header">Subir nueva imagen</div>
					<div class="field">
						<input type="hidden" name="product_id" value="<?php echo $productData['id']?>">
						<input class="ui button" type="file" name="imageFile" id="imageFile">
						<div id="uploadImageButton" class="ui button">Subir</div>
					</div>
				</form>
			</div>
		</div>
		<div class="six wide column">
			<div class="ui segment">
				<?php
					echo '<i data-code="'.$productCode.'" data-product-id="'.$productData['id'].'" video-ext="'.$productData['videoExtension'].'" id="videoRemove" class="remove icon"></i>';
					if($productData['videoExtension']) echo '<video src="data/video/products/'.$productData['id'].'.'.$productData['videoExtension'].'" width="366" controls></video>';
					else echo 'No existe video para mostrar';
				?>
				<form id="videoForm" class="ui form" class="ui form" action="" method="post" enctype="multipart/form-data">
					<div class="ui dividing header"></div>
					<div class="ui header">Subir/reemplazar video</div>
					<div class="field">
						<input type="hidden" name="product_id" value="<?php echo $productData['id']?>">
						<input class="ui button" type="file" name="videoFile" id="videoFile">
						<div id="uploadVideoButton" class="ui button">Subir</div>
					</div>
				</form>
			</div>
		</div>		
	</div>
</div>
<?php include("adminSections/section-bottom.php") ?>
<script>
	$(function(){
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});


		///////////////////////////////////////////////////////////////////////////////
		$('#uploadImageButton.ui.button').click(function(e){
			e.preventDefault();
			$('#modalConfirmacionSubirImagen.ui.basic.modal').modal('show');
		});
		$('#modalConfirmacionSubirImagen.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				$('#imageForm.ui.form').submit();
			}
		});

		let idImg;
		let code;
		$('#imgRemove.remove.icon').click(function(e){
			idImg = e.target.getAttribute('data-idimg');
			code = e.target.getAttribute('data-code');
			$('#modalConfirmacionBorrarImagen.ui.basic.modal').modal('show');
		});
		$('#modalConfirmacionBorrarImagen.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				window.location = "admin-edit-files.php?code="+code+"&imageFileRemoveId="+idImg;
			}
		});


		$('#uploadVideoButton.ui.button').click(function(e){
			e.preventDefault();
			$('#modalConfirmacionSubirVideo.ui.basic.modal').modal('show');
		});
		$('#modalConfirmacionSubirVideo.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				$('#videoForm.ui.form').submit();
			}
		});


		let productId;
		let videoExtension;
		$('#videoRemove.remove.icon').click(function(e){
			productId = e.target.getAttribute('data-product-id');
			code = e.target.getAttribute('data-code');
			videoExtension = e.target.getAttribute('video-ext');
			$('#modalConfirmacionBorrarVideo.ui.basic.modal').modal('show');
		});
		$('#modalConfirmacionBorrarVideo.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				window.location = "admin-edit-files.php?code="+code+"&videoRemoveProductId="+productId+"&videoExtension="+videoExtension;
			}
		});

	});
</script>
<?php 
	/*unset($productsList, $id, $key, $row, $value);*/
?>