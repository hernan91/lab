SELECT S.`id` AS sale_id, P.`id` AS product_id, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity, S.`date` as date FROM `products` AS P, `bills` AS B, `sales` AS S WHERE P.`id` = B.`id_product` AND S.`id` = B.`id_sale` AND S.`id_user` = '15' AND S.`selled` = '0'





SELECT S.`id` AS sale_id, S.`date` as date, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity 

FROM `products` AS P, `bills` AS B, `sales` AS S 
WHERE P.`id` = B.`id_product`
	AND S.`id` = B.`id_sale` 
	AND S.`id_user` = '15' 
	AND S.`selled` = '1'
	AND S.`id` IN(
		SELECT `id` FROM `users` WHERE `id_user`='15'
	)


SELECT S.`id` AS sale_id, S.`date` as date, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity 
FROM `products` AS P, `bills` AS B, `sales` AS S 
WHERE S.`id` = B.`id_sale`
AND S.`id` IN(
		SELECT `id` FROM `users` WHERE `id_user`='15' AND `selled`=1
	)
ORDER BY `id_sale`


//getProductos(idSales)
SELECT `id_product` FROM `bills` WHERE `id_sale`='10'
//getVentas(idUser)
SELECT `id`,`date` FROM `sales` WHERE `id_user`='15' AND `selled`=1

SELECT P.`id`, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity
FROM `products` AS P, `bills` AS B
WHERE P.`id` = B.`id_product`


arrayVentas = api_internal_getFinishedSalesByUser(idUser);

foreach(arrayventas as ventas){
	arrayProductos = api_internal_getProductsBySale(ventas.idsale);
	foreach(arrayProductos as producto){
		dataProducto = api_internal_products_getProductData(producto.id)
		tabla(dataProducto)
	}
}

SELECT P.`id` AS product_id, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity FROM `products` AS P, `bills` AS B WHERE P.`id` = B.`id_product` AND S.`id` = '$idSsale'