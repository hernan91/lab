<!DOCTYPE html>
<html lang="en">
	
<head>
	<?php include("clientSections/sections/header.php") ?>
	<link rel="stylesheet" href="css/loginStyle.css">
</head>

<body>

	<div class="ui middle aligned center aligned grid">
		<div class="column">
			<h2 class="ui teal image header">
			<div class="content">
				Ingrese a SportStore
			</div>
			</h2>
			<form class="ui large form">
				<div class="ui stacked segment">
					<div class="field">
					<div class="ui left icon input">
						<i class="user icon"></i>
						<input type="text" name="email" placeholder="E-mail address">
					</div>
					</div>
					<div class="field">
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="password" placeholder="Password">
					</div>
					</div>
					<div class="ui fluid large teal submit button">Entrar</div>
				</div>

				<div class="ui error message"></div>
			</form>
		</div>
	</div>
</div>
	




</body>