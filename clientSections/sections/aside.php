<?php
	include_once 'api/internal/categories.php';


	$categoriesList = api_internal_categories_getAllCategoriesData();
?>

<div class="ui vertical fixed menu" style="margin-top:100px">
	<div class="item">
		<h3 class="ui header">Productos</h3>	
	</div>
	<div class="ui segment">
		<form class="ui form">
			<div class="grouped fields">
				<label>Opciones de filtrado</label>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="field" checked="checked">
						<label>Por código</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="field">
						<label>Por fabricante</label>
					</div>
				</div>
				<div class="field">
					<div id="radioPrice" class="ui radio checkbox">
						<input type="radio" name="field">
						<label>Precio menor a</label>
					</div>
				</div>
				<div class="field">
					<div id="radioPrice" class="ui radio checkbox">
						<input type="radio" name="field">
						<label>Precio mayor a</label>
					</div>
				</div>
			</div>
			<button class="ui basic button">
				<i class="icon search"></i>
				Buscar
			</button>
		<form>
	</div>

	<a href="index.php" class="item">
		Todas las categorías
	</a>
	<div class="item">
		Por categorias
		<div class="menu">
			<?php
				foreach($categoriesList as $category){
					echo '<a href="index.php?categoryId='.$category["id"].'" class="item">'.$category['name'].'</a>';
				}
			?>
		</div>
	</div>
</div>
<script>
	$(function(){

	});
</script>