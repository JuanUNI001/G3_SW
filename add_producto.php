<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
</head>

<body>

<div id="contenedor">

<?php
	require('cabecera.php');
	require('sidebarIzq.php');
?>

<main>
	<article>
		<h1>Registrar Producto</h1>

		<form action="procesar_add_Producto.php" method="POST">
		<fieldset>
			<legend>Datos del Producto</legend>
			<div><label>Name:</label> <input type="text" name="prod_name" /></div>
			<div><label>ID:</label> <input type="num" name="prod_ID" /></div>
            <div><label>Precio:</label> <input type="num" name="prod_precio" /></div>
			<div><button type="submit">Crear</button></div>
		</fieldset>
	</article>
</main>

<?php
	require('sidebarDer.php');
	require('pie.php');
?>
</div>

</body>
</html>