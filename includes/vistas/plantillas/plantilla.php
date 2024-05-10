<?php
require_once __DIR__.'/../../config.php';

use es\ucm\fdi\aw\src\BD;


$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.7.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/valoraciones.js') ?>"></script>
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/validacionRegistro.js') ?>"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js" integrity="sha256-XCdgoNaBjzkUaEJiauEq+85q/xi/2D4NcB3ZHwAapoM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js" integrity="sha256-GcByKJnun2NoPMzoBsuCb4O2MKiqJZLlHTw3PJeqSkI=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



   
    
</head>
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

<?php

$scripts = $params['scripts'] ?? [];
foreach ($scripts as $scriptSrc) {
	echo "<script src=\"{$scriptSrc}\"></script>";
}
?>

</body>
</html>
