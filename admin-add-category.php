<?php 
	define('PAGE', "admin-add-category"); 
	define('LEVEL', 2);
	include_once 'api/auth.php';
?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/categories.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea agregar esta categoría?", "modalConfirmacion");

	$success = false;
	$errors = array();
	$id = $code = $name = $description = "";
	$val = false;
	if(isset($_POST['code'])){
		$code = $_POST['code'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$val = api_internal_categories_newCategory($code, $name, $description);
	}
	
	if(is_array($val)) $errors = $val;
	else $success = $val;
?>
	<div class="ui <?php echo $success?"":"hidden" ?> success message">
		<i class="close icon"></i>
		<div class="header">Carga completa!</div>
		<p>La categoría <?php echo '<b>'.$name.'<b/>' ?> se añadió correctamente a la lista de categorías</p>
	</div>

	<div class="ui segment">
		<form method="POST" class="ui form" id="formAgregarCategoria">
			<h3 class="ui dividing header"><b>Formulario para crear una nueva categoría</b></h3>
			<div class="two fields">
				<div class="required field">
					<label>Código</label>
					<input type="text" name="code" placeholder="Ingrese un código de categoría" value="<?php echo $success?'':$code ?>">
				</div>
				<div class="required field">
					<label>Nombre</label>
					<input type="text" name="name" placeholder="Ingrese un nombre de categoría" value="<?php echo $success?'':$name ?>">
				</div>
			</div>
			<div class="fields">				
				<div class="twelve wide field">
					<label>Descripcion</label>
					<textarea name="description" placeholder="Describa la categoría"><?php echo $success?'':$description ?></textarea>
				</div>
			</div>
			<div class="ui error message"></div>
			<div>
				<div class="ui basic blue button" tabindex="0" id="botonCrear">Crear</div>
				<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
			</div>
		</form>
		<div class="ui <?php echo is_array($val)?'':'hidden' ?> error message">
			<i class="close icon"></i>
			<div class="header">
				Hubieron errores al agregar la nueva categoría
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

<script src="js/admin-add-category.js"></script>