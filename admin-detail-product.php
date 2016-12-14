<?php
	define('PAGE', "admin-detail-product"); 
	define('LEVEL', 2);
	include_once 'api/auth.php';
?>	
?>

<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/products.php");
?>
<?php
	$code = isset($_GET['code'])?$_GET['code']:die('<h3>Se produjo un problema al realizar la consulta</h3>');
	$productData = api_internal_products_getAllProductData($code);
	$productImagesData = api_internal_products_getProductImagesData($productData['id']);
	if(count($productImagesData)>0) $firstImageFilename = $productImagesData[0]['id'].'.'.$productImagesData[0]['extension'];
	else $firstImageFilename = "";
	/*$success = isset($_GET['success']);
	$error = isset($_GET['error']);*/
?>

<!--
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
-->

<div class="ui <?php echo (isset($productData))?'hidden':''?> warning message">
	<div class="header">Advertencia</div>
	No existe el producto solicitado
</div>

<div class="ui segment <?php echo (isset($productData))?'hidden':''?> ">
	<h3 class="ui dividing header"><b>Información del producto seleccionado</b></h3>
	<div class="ui grid"> <!--internally celled-->
		<div class="two wide column">
			<div class="ui segment">
				<?php
					foreach($productImagesData as $imageData){
						echo '<img class="ui centered tiny image" src="data/img/products/'.$imageData['id'].".".$imageData['extension'].'">';
						if($imageData!=end($productImagesData)) echo '<div class="ui divider"></div>';
					}
				?>
			</div>
		</div>
		<div class="six wide column">
			<div class="ui segment">
				<?php
					if(count($productImagesData)==0) echo '<h3>No existen imágenes para mostrar</h3>';
					else echo '<img id="mainImage" class="ui centered medium image" src="'.'data/img/products/'.$firstImageFilename.'">';
				?>
			</div>
		</div>
		<div class="seven wide column">
			<div class="ui segment">
				<div class="ui top attached tabular menu">
					<a class="item active" data-tab="first">Datos basicos</a>
					<a class="item" data-tab="second">Descripcion</a>
					<a class="item" data-tab="third">Video</a>
				</div>
				<div class="ui bottom attached tab segment active" data-tab="first">
					<div class="ui list">
						<div class="item">
							<div class="header">Código</div>
							<?php echo $productData['code']?>
						</div>
						<div class="item">
							<div class="header">Nombre</div>
							<?php echo $productData['name']?>
						</div>
						<div class="item">
							<div class="header">Precio</div>
							<?php echo $productData['price']?>
						</div>
						<div class="item">
							<div class="header">Categoría</div>
							<?php echo $productData['catName']?>
						</div>
						<div class="item">
							<div class="header">Fabricante</div>
							<?php echo $productData['manufacturer']?>
						</div>
						<div class="item">
							<div class="header">Estado</div>
							<?php echo $productData['state']?>
						</div>
						<div class="item">
							<div class="header">Stock</div>
							<?php echo $productData['stock']?>
						</div>
					</div>
				</div>
				<div class="ui bottom attached tab segment" data-tab="second">
					<?php 
						if(!$productData['description']) echo "<h4>No existe una descripción del producto</h4>";
						else echo $productData['description'];
						
					?>
				</div>
				<div class="ui bottom attached tab segment" data-tab="third">
					<?php
						if($productData['videoExtension']) echo '<video src="data/video/products/'.$productData['id'].'.'.$productData['videoExtension'].'" width="406" controls></video>';
						else echo 'No existe video para mostrar';
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("adminSections/section-bottom.php") ?>
<script>
	$(function(){
		$('.ui.embed').embed();
		$('.menu .item').tab();
		$('.ui.tiny.image').click(function(e){
			$('#mainImage').attr("src", event.target.src);
		});
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
	});
</script>
<?php 
	/*unset($productsList, $id, $key, $row, $value);*/
?>