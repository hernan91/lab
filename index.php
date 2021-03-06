<?php 
	define('PAGE', "index"); 
	define('LEVEL', 1);
	include_once 'api/auth.php';
?>

	<?php 
		include("clientSections/section-top.php");
		include_once 'components/cardProduct.php';
		include_once 'components/cardProductMostSelled.php';
		include_once 'api/internal/products.php';
		include_once 'api/internal/categories.php';
		include_once 'components/modalConfirm.php';
		components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea agregar este producto al carrito?", "modalConfirmacion");
		
		$mostSelledProductsList;
		$categoryProductsList;
		$searchedProductsList;
		if(!isset($_GET['categoryId']) && !isset($_GET['field'])){
			$mostSelledProductsList = api_internal_products_getMostSelledAvailableProducts();
			$allProductsList = api_internal_products_getAllAvailableProductsBasicData();
			$title = "Productos mas vendidos";
		}
		else if(isset($_GET['categoryId'])){
			$categoryId = $_GET['categoryId'];
			$categoryData = api_internal_categories_getCategoryData($categoryId);
			$categoryProductsList = api_internal_products_getAllAvailableProductsBasicDataByCategory($categoryId);
			$title = 'Productos de la categoría '.$categoryData['name'];
		}
		else if(isset($_GET['text']) && isset($_GET['field'])){
			if($_GET['field']=="name"){
				$searchedProductsList = api_internal_products_getProductsByNameLike($_GET['text']);
				$allProductsList = api_internal_products_getAllAvailableProductsBasicData();
				$title = "Productos filtrados por el nombre <b>".$_GET['text']."</b>";
			}
			else if($_GET['field']=="code"){
				$searchedProductsList = api_internal_products_getProductsByCodeLike($_GET['text']);
				$allProductsList = api_internal_products_getAllAvailableProductsBasicData();
				$title = "Productos filtrados por el código <b>".$_GET['text']."</b>";
			}
			else if($_GET['field']=="manufacturer"){
				$searchedProductsList = api_internal_products_getProductsByManufacturerLike($_GET['text']);
				$allProductsList = api_internal_products_getAllAvailableProductsBasicData();
				$title = "Productos filtrados por el fabricante <b>".$_GET['text']."</b>";
			}
			else if($_GET['field']=="priceLessThan"){
				$searchedProductsList = api_internal_products_getProductsByPriceLessThan($_GET['text']);
				$allProductsList = api_internal_products_getAllAvailableProductsBasicData();
				$title = "Productos filtrados por precio menor a <b>".$_GET['text']."</b>";
			}
			else if($_GET['field']=="priceBiggerThan"){
				$searchedProductsList = api_internal_products_getProductsByPriceBiggerThan($_GET['text']);
				$allProductsList = api_internal_products_getAllAvailableProductsBasicData();
				$title = "Productos filtrados por precio mayor a <b>".$_GET['text']."</b>";
			}
		}
		
		$registered = true;
	?>

	<div class="ui raised segment">
		<h3 class="ui header"><?php echo $title ?></h3>
		<div class="ui cards">
			<?php
				if(isset($searchedProductsList)){
					foreach($searchedProductsList as $product){
						$firstImage = api_internal_products_getFirstImg($product['id']);
						components_cardProduct($product['id'], $product['name'], $product['code'], $product['manufacturer'], $product['catName'], $product['price'], $firstImage['id'], $firstImage['extension'], $product['stock'], isset($_SESSION['logged']));
					}
				}
				if(isset($mostSelledProductsList)){
					foreach($mostSelledProductsList as $selledProduct){
						$firstImage = api_internal_products_getFirstImg($selledProduct['id']);
						components_cardProductMostSelled($selledProduct['id'], $selledProduct['name'], $selledProduct['code'], $selledProduct['manufacturer'], $selledProduct['catName'], $selledProduct['price'], $firstImage['id'], $firstImage['extension'], $selledProduct['quantity'], $selledProduct['stock'], isset($_SESSION['logged']));
					}
				}
				else if(isset($categoryProductsList)){
					foreach($categoryProductsList as $categoryProduct){
						$firstImage = api_internal_products_getFirstImg($categoryProduct['id']);
						components_cardProduct($categoryProduct['id'], $categoryProduct['name'], $categoryProduct['code'], $categoryProduct['manufacturer'], $categoryProduct['catName'], $categoryProduct['price'], $firstImage['id'], $firstImage['extension'], $categoryProduct['stock'], isset($_SESSION['logged']));
					}
				}
			?>
		</div>
	</div>
	<div style="margin-top:100px;"></div>
	<div class="ui raised segment">
		<h3 class="ui header"><?php echo isset($allProductsList)?"Todos los productos":"" ?></h3>
		<div class="ui four cards">
			<?php
				//falta manejo sesion
				if(isset($allProductsList)){
					foreach($allProductsList as $product){
						$firstImage = api_internal_products_getFirstImg($product['id']);
						components_cardProduct($product['id'], $product['name'], $product['code'], $product['manufacturer'], $product['catName'], $product['price'], $firstImage['id'], $firstImage['extension'], $product['stock'], isset($_SESSION['logged']));
					}
				}
			?>
		</div>
	</div>
	
	<?php include("clientSections/section-bottom.php") ?>

<script>
	let addToCartForm;
	$('#modalConfirmacion.ui.basic.modal').modal({
		closable: false,
		onApprove: function(){
			addToCartForm.submit();
		}
	});
	$('.addToCartAnchor').click(function(e){
		e.preventDefault();
		addToCartForm = $(e.target).parents('form');
		$('#modalConfirmacion.ui.basic.modal').modal('show');
	});
</script>