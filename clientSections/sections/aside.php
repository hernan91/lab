<?php
	include_once 'api/internal/categories.php';


	$categoriesList = api_internal_categories_getAllCategoriesData();
?>

<div class="ui vertical fixed menu" style="margin-top:100px">
	<div class="item">
		<h3 class="ui header">Productos</h3>	
	</div>
	<div class="item">
		<div class="ui input"><input type="text" placeholder="Buscar producto..."></div>
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
	<!--<a class="item">
		<i class="grid layout icon"></i> Browse
	</a>
	<a class="item">
		Messages
	</a>
	<div class="ui dropdown item">
		More
		<i class="dropdown icon"></i>
		<div class="menu">
			<a class="item"><i class="edit icon"></i> Edit Profile</a>
			<a class="item"><i class="globe icon"></i> Choose Language</a>
			<a class="item"><i class="settings icon"></i> Account Settings</a>
		</div>
	</div>-->
</div>