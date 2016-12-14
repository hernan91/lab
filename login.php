<?php
	$errors = array();
	$username = "";
	if(isset($_POST['username']) && isset($_POST['password'])){
		include_once 'api/login.php';
		$result = handleLogin($_POST['username'], $_POST['password']);
		if(is_array($result)){
			$errors = $result;
			$username = $_POST['username'];
		}
		else{
			if($_SESSION['level']>1) return header("Location: admin-list-users.php"); 
			else return header("Location: index.php");
		} 
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("clientSections/sections/header.php") ?>
</head>

<body style="background-color: #E9E9E9">
	<div style="height: 100%" class="ui middle aligned center aligned grid">
		<div style="max-width: 450px" class="column">
			<div class="ui <?php echo isset($_GET['error'])?" ":"hidden " ?> error message">
				<i class="close icon"></i>
				<div class="header">Surgió un error al realizar la operación</div>
				<p>
					<?php echo isset($_GET['error'])?$_GET['error']:""?>
				</p>
			</div>
			<h2 class="ui image header">
				<div class="content">
					Ingrese a TecnoStore
				</div>
			</h2>
			<form id="loguear" method="post" class="ui large form">
				<div class="ui stacked segment">
					<div class="field">
						<div class="ui left icon input">
							<i class="user icon"></i>
							<input type="text" name="username" placeholder="Ingrese su nombre de usuario" value="<?php echo $username?>">
						</div>
					</div>
					<div class="field">
						<div class="ui left icon input">
							<i class="lock icon"></i>
							<input id="password" type="password" data-validate="password" placeholder="Ingrese su contraseña">
							<input id="cryptedPasswordField" type="hidden" name="password">
						</div>
					</div>
					<div id="buttonIngresar" class="ui fluid large black submit button">Entrar</div>
				</div>
			</form>
			<div class="ui <?php echo count($errors)>0?'':'hidden' ?> error message">
					<i class="close icon"></i>
					<div class="header">
						Error
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
	</div>
	</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<script>
	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});
	$('#buttonIngresar.ui.button').click(function(e){
		e.preventDefault();
		cryptPass();
		$('#loguear.ui.form').form('submit');
	});
	function cryptPass(){
		let userForm = $('#formAgregarUsuario.ui.form');
		let passwordField = $('#password');
		let cryptedPassword = CryptoJS.MD5(passwordField.val());
		$('#cryptedPasswordField').val(cryptedPassword);
	}
	$('#loguear.ui.form').form({
		on:'blur',
		inline : true,
		fields: {
			username: {
				identifier : 'username',
				rules: [{
					type   : 'empty',
					prompt : 'Ingrese un usuario'
				},{
					type	: 'minLength[6]',
					prompt	: 'El nombre de usuario debe tener al menos 6 caracteres'
				}]
			},
			password: {
				identifier : 'password',
				rules: [{
					type   : 'empty',
					prompt : 'Ingrese una contraseña'
				},{
					type	: 'minLength[6]',
					prompt	: 'La contraseña debe tener al menos 6 caracteres'
				}]
			}
		}
	});
</script>
</html>