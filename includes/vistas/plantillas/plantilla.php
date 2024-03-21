<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilo.css" />
</head>
<body> 
<div id="contenedor">
<?php
require(RUTA_VISTAS.'/cabecera.php');
require(RUTA_VISTAS.'/sidebarIzq.php');
?>
	<main>
		<article>
			<?= $contenidoPrincipal ?>
		</article>
	</main>
<?php
require(RUTA_VISTAS.'/sidebarDer.php');
require(RUTA_VISTAS.'/pie.php');
?>
</div>
</body>
</html>
