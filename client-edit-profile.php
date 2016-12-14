<?php 
	define('PAGE', "client-edit-profile");
	define('LEVEL', 1);
	include_once 'api/auth.php';
?>	
?>
<?php 
	include("clientSections/section-top.php");
	include_once("api/internal/users.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea modificar sus datos?", "modalConfirmacion");

	$success = isset($_GET['success']);
	$error = isset($_GET['error']);
	$val = false;
	$userData = api_internal_users_getUserData($_SESSION['id']);
	$id = $_SESSION['id'];
	$completed = false;
	$email = $direction = $phone = "";

	if(!isset($_POST['email'])){
		$email = $userData['email'];
		$direction = $userData['direction'];
		$phone = $userData['phone'];
		$completed = !empty($email) && !empty($direction) && !empty($phone);
	}
	else{
		$email = $_POST['email'];
		$direction = $_POST['direction'];
		$phone = $_POST['phone'];
		$val = api_internal_users_newUploadData($id, $email, $direction, $phone);
		if(is_array($val)) $errors = $val;
		else{
			$success = $val;
			if($success){
				return header('Location: client-edit-profile.php?success=Sus datos se modificaron correctamente');
				$completed = true;
			}
			else{
				return header('Location: client-edit-profile.php?error=Hubieron errores al modificar sus datos');
			}
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

	<div class="ui <?php echo ($completed)?'hidden':''?> warning message">
		<div class="header">Advertencia</div>
		Los siguientes datos son obligatorios para realizar una compra
	</div>

	<div class="ui <?php echo ($completed)?'':'hidden'?> info message">
		<i class="close icon"></i>
		<div class="header">Información</div>
		<ul class="list">
			<li>Sus datos ya estan completos</li>
		</ul>
	</div>

	<div class="ui segment">
		<form method="POST" class="ui form" id="formModificarUsuario">
			<h3 class="ui dividing header"><b>Formulario para completar sus datos</b></h3>
			<div class="three fields">
				<input type="hidden" name="id" value="<?php echo $id?>"></input>
				<div class="field required">
					<label>Dirección de correo electrónico</label>
					<input type="email" name="email" placeholder="Ingrese un e-mail" value="<?php echo $email ?>">
				</div>
				<div class="field required">
					<label>Direccion</label>
					<input type="text" name="direction" placeholder="Ingrese una dirección" value="<?php echo $direction ?>">
				</div>
				<div class="field required">
					<label>Teléfono</label>
					<input type="text" name="phone" placeholder="Ingrese un número de teléfono" value="<?php echo $phone ?>">
				</div>
			</div>
			
			<div class="ui error message"></div>
			<div>
				<div class="ui basic blue button" tabindex="0" id="botonModificar">Modificar</div>
				<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
			</div>
		</form>
		<div class="ui <?php echo is_array($val)?'':'hidden' ?> error message">
			<i class="close icon"></i>
			<div class="header">
				Hubieron errores al modificar sus datos
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
	
<script>
	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});
	$('#botonLimpieza.ui.button').click(function(e){
		e.preventDefault();
		$('#formModificarUsuario.ui.form').form('reset');
	});

	let modalConfirmed = false;
	$('#modalConfirmacion.ui.basic.modal').modal({
		closable: false,
		onApprove: function(){
			modalConfirmed = true;
			$('#formModificarUsuario.ui.form').form('submit');
		}
	});
	$('#botonModificar.ui.button').click(function(e){
		e.preventDefault();
		$('#formModificarUsuario.ui.form').form('submit');
	});		
	function onValidForm(e, fields){
		if(!modalConfirmed){
			e.preventDefault();
			$('#modalConfirmacion.ui.basic.modal').modal('show');	
		}
	}
	$('.ui.form').form({
		on:'blur',
		inline : true,
		onSuccess: onValidForm,
		fields: {
			email: {
				identifier: 'email',
				rules: [{
					type   : 'empty',
					prompt : 'Por favor ingrese un email'
				},{
					type   : 'email',
					prompt : '{value} no es una dirección de correo válida'
				}]
			},
			direction: {
				identifier: 'direction',
				rules: [{
					type   : 'empty',
					prompt : 'Por favor ingrese una dirección'
				}]
			},
			phone: {
				identifier: 'phone',
				rules: [{
					type   : 'empty',
					prompt : 'Por favor ingrese un número de teléfono'
				},{
					type	: 'minLength[5]',
					prompt	: 'El número de telefono debe tener al menos 5 números'
				},
				{
					type	: 'integer',
					prompt	: 'El teléfono debe ser un número'
				}]
			}
		}
	});
</script>
<?php 
	//unset();
?>