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
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/anunciosIndex.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" integrity="sha256-5veQuRbWaECuYxwap/IOE/DAwNxgm4ikX7nrgsqYp88=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.7.1.min.js') ?>"></script>
   



    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/mensajes.js') ?>"></script>

    
</head>
<body>
<?= $mensajes ?>
<div id="mi-contenedor">
<?php

$params['app']->doInclude('/vistas/comun/cabecera.php', $params);
//$params['app']->doInclude('/vistas/comun/sidebarIzq.php', $params);
?>
	 <main class="mi-main">
        <article class="mi-article">
			<?= $params['contenidoPrincipal'] ?>
      
		</article>
	
<?php
$params['app']->doInclude('/vistas/comun/sidebarDer.php', $params);
?>
</main>

<?php

$params['app']->doInclude('/vistas/comun/pie.php', $params);
?>
</div>
</body>
</html>
