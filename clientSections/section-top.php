<?php
	define('ADMIN_PATH_LEVEL', false);
	define('DEBUG', true);
?>
<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php include("clientSections/sections/head.php") ?>
	</head>

	<header>
		<?php include("clientSections/sections/header.php") ?>
	</header>
	<nav>
		<?php include("clientSections/sections/nav.php") ?>
	</nav>

	<aside>
		<?php
			(PAGE=='index')? include("clientSections/sections/aside.php"):null 
		?>
		<?php include("clientSections/sections/cart.php") ?>
	</aside>

	<section>
		<div class="ui container">
			