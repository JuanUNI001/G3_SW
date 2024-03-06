<?php

//Inicio del procesamiento
session_start();

//Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['esAdmin']);
unset($_SESSION['nombre']);


session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Logout</title>
</head>

<body>

<div id="contenedor">
<?php
	require('/G3_SW/includes/views/cabecera.php');
	require('/G3_SW/includes/views/sidebarIzq.php');
?>

<main>
	<article>
		<h1>Hasta pronto!</h1>
	</article>
</main>
<?php
	require('/G3_SW/includes/views/sidebarDer.php');
	require('/G3_SW/includes/views/pie.php');
?>
</div>

</body>
</html>