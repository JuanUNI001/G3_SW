<?php

//Inicio del procesamiento
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Admin</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
?>
<main>
	<article>
	<?php
		if (!isset($_SESSION["esAdmin"])) {
			echo '<h1>Acceso denegado!</h1>';
			echo '<p>No tienes permisos suficientes para administrar la web.</p>';
			
		}else{
			echo '<h1>Consola de administración</h1>';
			echo'<p>Aquí estarían todos los controles de administración</p>';
			echo'<ul> <li><a href="add_producto.php">Crear Producto</a></li> </ul>';
		}
	?>
	</article>
</main>
<?php

	require("sidebarDer.php");
	require("pie.php");

?>
</div>

</body>
</html>