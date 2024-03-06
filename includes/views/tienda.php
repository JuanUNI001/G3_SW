<?php

//Inicio del procesamiento
session_start();

?>
 
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Tienda</title>
</head>

<body>

<div id="contenedor">

<?php
	require('cabecera.php');
	require('sidebarIzq.php');
?>

<main>
	<article>

		<h1>Producto1</h1>
		<p>descripcion </p>

</main>
<?php

	require('/G3_SW/includes/views/sidebarDer.php');
	require('/G3_SW/includes/views/pie.php');

?>
</div>

</body>
</html>