<?php define('PAGE', "admin-edit-product") ?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/products.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea modificar este producto?", "modalConfirmacion");

	$success = false;
	$errors = array();
	$id = $code = $name = $manufacturer = $category_id = $price = $state = $stock = $description = "";
	$val = false;
	$categoriesList = api_internal_products_getAllCategoriesData();
	
	if(isset($_GET['code'])){
		$code = $_GET['code'];
		if(!isset($_POST['name'])){
			$productData = api_internal_products_getAllProductBasicData($_GET['code']);
			$id = $productData['id'];
			$code = $productData['code'];
			$name = $productData['name'];
			$manufacturer = $productData['manufacturer'];
			$price = $productData['price'];
			$state = $productData['state'];
			$stock = $productData['stock'];
			$description = $productData['description'];
			$category_id = $productData['category_id'];
		}
		else{
			$id = $_POST['id'];
			$code = $_POST['code'];
			$name = $_POST['name'];
			$manufacturer = $_POST['manufacturer'];
			$price = $_POST['price'];
			$state = $_POST['state'];
			$stock = $_POST['stock'];
			$description = $_POST['description'];
			$category_id = $_POST['category_id'];
			$val = api_internal_products_modifyProduct($id, $code, $name, $manufacturer, $category_id, $price, $state, $stock, $description);
			if(is_array($val)) $errors = $val;
			else{
				$success = $val;
				if($success){
					header('Location: admin-list-products.php?success=Producto%20<b>'.$name.'</b>%20modificado%20correctamente');
					die();
				}
				else{
					header('Location: admin-list-users.php?error=El%20producto%20<b>'.$name.'</b>%20no%20pudo%20modificarse%20correctamente');
					die();
				}
			}
		}
	}
?>
	<div class="ui info message">
		<i class="close icon"></i>
		<div class="header">
			Información
		</div>
		<ul class="list">
			<li>Cualquier contenido multimedia (imágenes o video) se podrá agregar una vez creado el producto</li>
		</ul>
	</div>

	<div class="ui segment">
		<form method="POST" class="ui form" id="formAgregarUsuario">
			<h3 class="ui dividing header"><b>Formulario para modificar un producto</b></h3>
			<div class="fields">
				<input type="hidden" name="id" value="<?php echo $id?>"></input>
				<div class="two wide field required">
					<label>Código</label>
					<input type="text" name="code" placeholder="Ingrese un código de producto" value="<?php echo $success?'':$code ?>">
				</div>
				<div class="seven wide field required">
					<label>Nombre</label>
					<input type="text" name="name" placeholder="Ingrese un nombre" value="<?php echo $success?'':$name ?>">
				</div>
				<div class="four wide field required">
					<label>Fabricante</label>
					<input type="text" name="manufacturer" placeholder="Ingrese un fabricante" value="<?php echo $success?'':$manufacturer ?>">
				</div>
				<div class="three wide required field">
					<label>Categoría</label>
					<select class="ui selection dropdown" id="dropRol" name="category_id">
						<option value="">Seleccione una categoría</option>
						<?php
							foreach($categoriesList as $category){
								$selected = (!$success && $category["id"]==$category_id)?"selected":"";
								echo '<option '.$selected.' value="'.$category['id'].'" >'.$category["name"].'</option>';
								//echo '<option value="'.$category["code"].'" '.(!$success && $category["name"]==$category_code)?"selected":"".'">'.$category["name"].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="fields">
				<div class="six wide required field">
					<label>Precio</label>
					<div class="ui left icon input">
						<input name="price" type="text" placeholder="Ingrese un precio" value="<?php echo $success?'':$price ?>">
						<i class="dollar icon"></i>
					</div>
				</div>
				<div class="eight wide required field">
					<label>Estado</label>
					<select class="ui selection dropdown" id="dropRol" name="state">
						<option value="">Seleccione un estado</option>
						<option data-value="Activo" value="Activo"<?php echo (!$success && $state=='Activo')?'selected':'' ?>>Activo</option>
						<option data-value="Inactivo" value="Inactivo"<?php echo (!$success && $state=='Inactivo')?'selected':'' ?>>Inactivo</option>
					</select>
				</div>
				<div class="four wide required field">
					<label>Stock</label>
					<input type="number" name="stock" min="0" placeholder="Ingrese el stock" value="<?php echo $success?'':$stock ?>">
				</div>
			</div>
			<div class="fields">				
				<div class="twelve wide field">
					<label>Descripcion</label>
					<textarea name="description" placeholder="Describa el producto" ><?php echo $success?'':$description ?></textarea>
					<!--<textarea name="description"  maxlength="1022" value=""></textarea>-->
				</div>
			</div>
			
			<div class="ui error message"></div>
			<div>
				<div class="ui basic blue button" tabindex="0" id="botonCrear">Modificar</div>
				<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
			</div>
		</form>
		<div class="ui <?php echo is_array($val)?'':'hidden' ?> error message">
			<i class="close icon"></i>
			<div class="header">
				Hubieron errores al modifcar el producto
			</div>
			<ul class="list">
				<?php 
					foreach($errors as $error){
						echo '<li>'.$error.'</li>';
					}
				?>
			</ul>
		</div>
	</div>
	<?php include("adminSections/section-bottom.php") ?>
	
<script src="js/admin-add-product.js"></script>
<?php 
	//unset();
?>