<?php define('PAGE', "admin-add-users") ?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/users.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea modificar este usuario?");

	$success = false;
	$errors = array();
	$id = $username = $password = $email = $name = $lastname = $dni = $direction = $role = "";
	$val = false;
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		if(!isset($_POST['username'])){
			$userData = api_internal_users_getUserData($_GET['id']);
			$username = $userData['username'];
			$email = $userData['email'];
			$name = $userData['name'];
			$lastname = $userData['lastname'];
			$dni = $userData['dni'];
			$direction = $userData['direction'];
			$role = $userData['role'];
		}
		else{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$name = $_POST['name'];
			$lastname = $_POST['lastname'];
			$dni = $_POST['dni'];
			$direction = $_POST['direction'];
			$role = $_POST['role'];
			$val = api_internal_users_modifyUser($id, $username, $password, $email, $name, $lastname, $dni, $direction, $role);
			if(is_array($val)) $errors = $val;
			else{
				$success = $val;
				if($success){
					header('Location: admin-list-users.php?success=Usuario%20<b>'.$username.'</b>%20modificado%20correctamente');
					die();
				}
				else{
					header('Location: admin-list-users.php?error=El%20usuario%20<b>'.$username.'</b>%20no%20pudo%20modificarse%20correctamente');
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
			<li>Por razones de seguridad, no se muestra la contraseña del usuario</li>
		</ul>
	</div>

	<div class="ui segment">
		<form method="POST" class="ui form" id="formAgregarUsuario">
			<h4 class="ui dividing header"><b>Formulario para modificar un producto</b></h4>
			<div class="three fields">
				<div class="required field">
					<label>Codigo</label>
					<input type="text" name="username" placeholder="Ingrese un nombre de usuario" value="<?php echo $success?'':$username ?>">
				</div>
				<div class="field">
					<label>Nombre</label>
					<input type="password" data-validate="password" id="password" placeholder="Ingrese una contraseña">
				</div>
				<div class="field">
					<label>Fabricante</label>
					<input type="password" data-validate="confPassword" id="confPassword" placeholder="Ingrese nuevamente la contraseña">
				</div>
			</div>
			<div class="fields">
				<div class="six wide required field">
					<label>Precio</label>
					<input type="text" name="name" placeholder="Ingrese un nombre" value="<?php echo $success?'':$name ?>">
				</div>
				<div class="six wide required field">
					<label>Estado</label>
					<input type="text" name="lastname" placeholder="Ingrese un apellido"  value="<?php echo $success?'':$lastname ?>">
				</div>
				<div class="eight wide required field">
					<label>Url de video</label>
					<input type="email" name="email" placeholder="Ingrese un e-mail" value="<?php echo $success?'':$email ?>">
				</div>
			</div>
			<div class="fields">
				<div class="four wide required field">
					<label>Stock</label>
					<input type="text" name="dni" placeholder="Ingrese un DNI" value="<?php echo $success?'':$dni ?>">
				</div>
				<div class="nine wide required field">
					<label>Direccion</label>
					<input type="text" name="direction" placeholder="Ingrese una dirección" value="<?php echo $success?'':$direction ?>">
				</div>
				<div class="three wide required field">
					<label>Rol</label>
					<select class="ui selection dropdown" id="dropRol" name="role">
						<option value="">Seleccione un rol</option>
						<option data-value="administrator" value="Administrador" <?php echo (!$success & $role=='Administrador')?'selected':'' ?>>Administrador</option>
						<option data-value="client" value="Cliente" <?php echo (!$success & $role=='Cliente')?'selected':'' ?>>Cliente</option>
					</select>
				</div>
			</div>
			<div class="ui error message"></div>
			<div>
				<div class="ui basic blue button" tabindex="0" id="botonCrear">Modificar</div>
				<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
			</div>
			<input type="hidden" id="cryptedPasswordField" name="password">
		</form>
		<div class="ui <?php echo is_array($val)?'':'hidden' ?> error message">
			<i class="close icon"></i>
			<div class="header">
				Surgieron errores al modificar el usuario
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
	
<script src="js/admin-edit-user.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<?php 
	//unset();
?>