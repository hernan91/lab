<?php define('PAGE', "admin-detail-products") ?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/products.php");
	include_once 'components/modalConfirm.php'; 
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
		include_once("api/internal/products.php");
		if(isset($_FILES['imageFile'])){
			include_once("api/internal/images.php");
			
			$code = $_GET['code'];
			$product_id = $_POST['product_id'];
			$imageFileType = pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION);
			api_internal_images_newImage($product_id, $imageFileType);
			$image_id = api_internal_getLastImageId();
			$file = 'data/img/products/'.$image_id.'.'.$imageFileType;
			
			// es una imagen?
			if(!getimagesize($_FILES["imageFile"]["tmp_name"])){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=El%20archivo%20no%20es%20una%20imágen&code=".$code);
			}
			
			// existe la imagen?
			if (file_exists($file)){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Ya%20existe%20la%20imágen&code=".$code);
			} 
			
			// tamaño
			if ($_FILES["imageFile"]["size"] > 500000){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Archivo%20demasiado%20grande%20&code=".$code);
			}
			
			// Formatos
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "gif" ){
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Formato%20incorrecto.%20Solo%20jpeg,jpg,png%20y%20gif.&code=".$code);
			}
			
			// Check if $uploadOk is set to true by an error
				/*api_internal_images_removeImage($image_id);
				header("Location: ?error=Hubo%20un%20error%20al%20subir%20la%20imagen");*/

			if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $file)) {
				return header("Location: ?code=".$code."&success=Imagen%20subida%20correctamente");
			} else {
				api_internal_images_removeImage($image_id);
				return header("Location: ?error=Hubo%20un%20error%20al%20subir%20la%20imagen&code=".$code);
			}
		}
		if(isset($_FILES['videoFile'])){

		}	
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
						if(count($productImagesData)==0) echo '<h3>No existen imágenes para mostrar</h3>';
						foreach($productImagesData as $imageData){
							echo '
								<div class="ui bordered image">
									<i data-idimg="'.$imageData['id'].'" class="remove icon"></i>
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
					if($productData['videoExtension']) echo '<video src="data/video/products/'.$productData['id'].'.'.$productData['videoExtension'].'" width="366" controls></video>';
					else echo 'No existe video para mostrar';
				?>
				<form class="ui form" action="" method="post" enctype="multipart/form-data">
					<div class="ui dividing header"></div>
					<div class="ui header">Subir/reemplazar video</div>
					<div class="field">
						<input type="hidden" name="product_id" value="<?php echo $productData['id']?>">
						<input class="" type="file" name="videoFile" id="videoFile">
						<div class="ui upload icon">Subir</div>
					</div>
				</form>
			</div>
		</div>		
	</div>
</div>
<?php include("adminSections/section-bottom.php") ?>
<script>
	$(function(){
		$('.remove.icon').click(function(e){
			let idImg = $('.remove.icon').attr('data-idimg');
			
		});
		$('#uploadImageButton').click(function(e){
			e.preventDefault();
			$('#modalConfirmacionSubirImagen.ui.basic.modal').modal('show');
		});
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
		$('#modalConfirmacionSubirImagen.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				$('#imageForm.ui.form').submit();
			}
		});
	});
</script>
<?php 
	/*unset($productsList, $id, $key, $row, $value);*/
?>