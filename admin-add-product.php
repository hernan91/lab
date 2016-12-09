<?php define('PAGE', "admin-add-users") ?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/products.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea agregar este usuario?");

	$success = false;
	$errors = array();
	$code = $name = $manufacturer = $catName = $price = $state = $stock = $description = "";
	$val = false;
	$categoriesList = api_internal_products_getAllCategoriesNames();
	if(isset($_POST['code'])){
		$code = $_POST['code'];
		$name = $_POST['name'];
		$manufacturer = $_POST['manufacturer'];
		$precio = $_POST['precio'];
		$videoUrl = $_POST['videoUrl'];
		$state = $_POST['state'];
		$stock = $_POST['stock'];
		$description = $_POST['description'];
		$catName = $_POST['catName'];
		$imagesList = api_internal_products_getProductImagesData($code);

		$val = api_internal_users_newUser($username, $password, $email, $name, $lastname, $dni, $direction, $role);
	}
	
	if(is_array($val)) $errors = $val;
	else $success = $val;
?>
	<div class="ui <?php echo $success?"":"hidden" ?> success message">
		<i class="close icon"></i>
		<div class="header">Carga completa!</div>
		<p>El usuario <?php echo $username ?> se añadió correctamente a la lista de usuarios</p>
	</div>

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
			<h3 class="ui dividing header"><b>Formulario para agregar un nuevo producto</b></h3>
			<div class="fields">
				<div class="three wide field required">
					<label>Código</label>
					<input type="text" name="code" placeholder="Ingrese un código de producto" value="<?php echo $success?'':$code ?>">
				</div>
				<div class="six wide field required">
					<label>Nombre</label>
					<input type="text" name="name" placeholder="Ingrese un nombre" value="<?php echo $success?'':$name ?>">
				</div>
				<div class="four wide field required">
					<label>Fabricante</label>
					<input type="text" name"manufacturer" placeholder="Ingrese un fabricante" value="<?php echo $success?'':$manufacturer ?>">
				</div>
				<div class="three wide required field">
					<label>Categoría</label>
					<select class="ui selection dropdown" id="dropRol" name="catName">
						<option value="">Seleccione una categoría</option>
						<?php
							foreach($categoriesList as $category){
								echo '<option data-value="client" value="Cliente" '.(!$success & $role=="Cliente")?"selected":"".'>Cliente</option>';
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
					<select class="ui selection dropdown" id="dropRol" name="catName">
						<option value="">Seleccione un estado</option>
						<option data-value="Activo" value="Activo">Activo</option>
						<option data-value="Inactivo" value="Inactivo">Inactivo</option>
					</select>
				</div>
				<div class="four wide required field">
					<label>Stock</label>
					<input type="number" name="dni" placeholder="Ingrese un DNI" value="<?php echo $success?'':$stock ?>">
				</div>
			</div>
			<div class="fields">				
				<div class="twelve wide required field">
					<label>Descripcion</label>
					<textarea name="dni" placeholder="Describa el producto" maxlength="1022" value="<?php echo $success?'':$description ?>"></textarea>
				</div>
			</div>
			
			<div class="ui error message"></div>
			<div>
				<div class="ui basic blue button" tabindex="0" id="botonCrear">Crear</div>
				<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
			</div>
			<input type="hidden" id="cryptedPasswordField" name="password">
		</form>
		<div class="ui <?php echo is_array($val)?'':'hidden' ?> error message">
			<i class="close icon"></i>
			<div class="header">
				Hubieron errores al agregar un nuevo usuario!
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
	
<script src="js/admin-add-user.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<?php 
	//unset();
?>