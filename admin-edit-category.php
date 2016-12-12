<?php define('PAGE', "admin-edit-category") ?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/categories.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea modificar esta categoría?", "modalConfirmacion");

	$success = false;
	$errors = array();
	$id = $code = $name = $description = "";
	$val = false;
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		if(!isset($_POST['id'])){
			$categoryData = api_internal_categories_getCategoryData($_GET['id']);
			$id = $categoryData['id'];
			$code = $categoryData['code'];
			$name = $categoryData['name'];
			$description = $categoryData['description'];;
		}
		else{
			$id = $_POST['id'];
			$code = $_POST['code'];
			$name = $_POST['name'];
			$description = $_POST['description'];
			$val = api_internal_categories_modifyCategory($id, $code, $name, $description);
			if(is_array($val)) $errors = $val;
			else{
				$success = $val;
				if($success){
					header('Location: admin-list-categories.php?success=Categoría%20<b>'.$name.'</b>%20modificada%20correctamente');
					die();
				}
				else{
					header('Location: admin-list-categories.php?error=La%20categoría%20<b>'.$name.'</b>%20no%20pudo%20modificarse%20correctamente');
					die();
				}
			}
		}
	}
?>

	<div class="ui segment">
		<form method="POST" class="ui form" id="formModificarCategoria">

			<h4 class="ui dividing header"><b>Formulario de modificación de categorías</b></h4>
			<input type="hidden" name="id" value="<?php echo $id ?>">
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
				<div class="ui basic blue button" tabindex="0" id="botonCrear">Modificar</div>
				<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
			</div>

		</form>
		<div class="ui <?php echo is_array($val)?'':'hidden' ?> error message">
			<i class="close icon"></i>
			<div class="header">
				Surgieron errores al modificar la categoría
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

<script src="js/admin-edit-category.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<?php 
	//unset();
?>