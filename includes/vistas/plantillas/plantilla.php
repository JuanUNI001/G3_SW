<?php
require_once __DIR__.'/../../config.php';

use es\ucm\fdi\aw\src\BD;
// Incluye el CSS necesario
echo '<link rel="stylesheet" type="text/css" href="../css/imagenes.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/conversacion.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/busqueda.css">';
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/imagenes.css') ?>" /></head>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" /></head>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/formulario.css') ?>" /></head>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/conversacion.css') ?>" /></head>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/usuarios.css') ?>" /></head>
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.7.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/valoraciones.js') ?>"></script>
<body>
<?= $mensajes ?>
<div id="contenedor">
<?php
$params['app']->doInclude('/vistas/comun/cabecera.php', $params);
//$params['app']->doInclude('/vistas/comun/sidebarIzq.php', $params);
?>
	<main>
		<article>
			<?= $params['contenidoPrincipal'] ?>
		</article>
	</main>
<?php
//$params['app']->doInclude('/vistas/comun/sidebarDer.php', $params);
$params['app']->doInclude('/vistas/comun/pie.php', $params);
?>
</div>
</body>
</html>
