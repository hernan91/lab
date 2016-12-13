<?php
	define('ADMIN_PATH_LEVEL', false);
	define('DEBUG', true);
?>
<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php include("clientSections/sections/head.php") ?>
	</head>
<body style="background-color: #E9E9E9;">
	<header>
		<?php include("clientSections/sections/header.php") ?>
	</header>
	<nav>
		<?php include("clientSections/sections/nav.php") ?>
	</nav>

	<aside>
		<?php
			if(PAGE=='index' || PAGE=='client-detail-product') include("clientSections/sections/aside.php"); 
		?>
		<?php include("clientSections/sections/cart.php") ?>
	</aside>

	<section style="margin-top:60px">
		<div class="ui container">
			