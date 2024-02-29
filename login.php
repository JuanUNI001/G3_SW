<?php

session_start();

?>

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
		<h1>Acceso al sistema</h1>

		<form action="procesarLogin.php" method="POST">
		<fieldset>
			<legend>Usuario y contraseña</legend>
			<div><label>Name:</label> <input type="text" name="username" /></div>
			<div><label>Password:</label> <input type="password" name="password" /></div>
			<div><button type="submit">Entrar</button></div>
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