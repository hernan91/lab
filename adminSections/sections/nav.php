<div class="ui inverted top fixed menu">
	<div class="item">
		<h3>TecnoStore ADMIN</h3>
	</div>
	<a class="item <?php echo (PAGE=='admin-list-users')?'active':'' ?>" href="admin-list-users.php">Listar usuarios</a>
	<div class="ui dropdown item" id="dropProductosNav"> <!--<?php echo (PAGE=='admin-list-products' || PAGE=='admin-list-categories')?'active':'' ?>-->
		Productos
		<i class="dropdown icon"></i>
		<div class="menu">
			<div class="header">Operaciones</div>
			<a class="item <?php echo (PAGE=='admin-list-products')?'active':'' ?>" href="admin-list-products.php">Listar productos</a>
			<a class="item <?php echo (PAGE=='admin-list-categories')?'active':'' ?>" href="admin-list-categories.php">Listar categorias</a>
		</div>
	</div>

	<div class="right menu">
		<a class="item" href="index.php">Ir a la página principal</a>
		<?php
			if(isset($_SESSION['name'])){
				echo '
					<div class="ui item">
						Bienvenido '.$_SESSION['name'].' 
					</div>
					<a href="api/logout.php"class="ui item">
						Salir
					</a>
				';
			}
		?>
	</div>
</div>
<script>
$("#dropProductosNav").dropdown({
	on: 'hover'
});
</script>

			<!--
	<i class="dropdown icon"></i>
		<div class="menu">
			<a class="item">Ver productos por categorias</a>
			<a class="item">Ver todos los productos</a>
		</div>
-->