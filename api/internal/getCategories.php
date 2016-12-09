<?php
	include("api.php");
	$json = api_getCategories(); 
	header("Content-Type: application/json");
	echo json_encode($json, JSON_PRETTY_PRINT);
?>