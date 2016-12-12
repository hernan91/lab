<?php
	function components_cardProduct($id, $name, $code, $manufacturer, $category, $price, $imgId, $imgExtension, $registered){
		$tagPrice = $registered?'<span class="date">$'.$price.'</span>':"";
		if($imgId==""||$imgExtension==""){
			$imgId = "Relleno";
			$imgExtension = "png";
		}
		$tagAddToCart = "";
		if($registered){
			$tagAddToCart = '
				<div style="margin-left:85px" class="ui left action input">
					<form id="addToCartForm"action="cart-add-product">
						<input type="hidden" name="id" value="'.$id.'">
						<a class="addToCartAnchor"><i class="cart icon"></i>Agregar</a>
						<input name="quantity" style="padding: 2px; width:30px" type="number" value="1" min="1">
					</form>
				</div>
			';
		}
		echo '
			<div class="ui card">
				<div class="ui slide masked reveal image">
					<img src="data/img/products/'.$imgId.'.'.$imgExtension.'" class="visible content">
					<div class="hidden content">
						<div class="ui segment">
							<b>Código</b><p>'.$code.'</p>
							<b>Fabricante</b><p>'.$manufacturer.'</p>
							<b>Categoria</b><p>'.$category.'</p>
						</div>
					</div>
				</div>
				<div class="content">
					<a class="header">'.$name.'</a>
					<div class="meta">
					'.$tagPrice.'
					</div>
				</div>
				<div class="extra content">
					<a><i class="add icon"></i>Ver mas</a>
					'.$tagAddToCart.'
				</div>
			</div>
		';
	}	
?>