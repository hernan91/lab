<div class="ui container">
	<div class="ui secondary pointing menu">
	<a href="index.php" class="active item">
		Inicio
	</a>
	<div class="right menu">
		
		<?php
			if(isset($_SESSION['name'])){
				echo '
					<div style="margin-right:30px; color:blue;" class="ui item">
						Bienvenido, '.$_SESSION['name'].'! 
					</div>
				';
				if($_SESSION['level']>1){
					echo '
						<a href="admin-list-users.php"class="ui item">
							Area de administración
						</a>
						';
				}
				echo '
					<a href="api/logout.php"class="ui item">
						Salir
					</a>
				';
			}
			else{
				echo '
					<a href="login.php" class="ui item">
						Ingresar
					</a>
				';
			}
		?>
	</div>
	</div>
</div>




			<!--
	<i class="dropdown icon"></i>
		<div class="menu">
			<a class="item">Ver productos por categorias</a>
			<a class="item">Ver todos los productos</a>
		</div>
-->