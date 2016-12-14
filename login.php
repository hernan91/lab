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
			<div class="ui <?php echo isset($_GET['success'])?" ":"hidden " ?> success message">
				<i class="close icon"></i>
				<div class="header">Operacion completada correctamente</div>
				<p>
					<?php echo isset($_GET['success'])?$_GET['success']:""?>
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
					<button id="buttonIngresar" class="ui fluid large black submit button">Entrar</button>
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
<script src="js/login.js">
</script>
</html>