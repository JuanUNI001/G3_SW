<?php
require_once __DIR__.'/../../config.php';

use es\ucm\fdi\aw\src\BD;
// Incluye el CSS necesario
echo '<link rel="stylesheet" type="text/css" href="../css/imagenes.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/conversacion.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/busqueda.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/formulario.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/usuarios.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/chat.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/anuncios.css">';
echo '<link rel="stylesheet" type="text/css" href="../css/anunciosIndex.css">';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>';

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
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/imagenes.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/conversacion.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/busqueda.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/formulario.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/usuarios.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/chat.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/anuncio.css') ?>" />
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/foro.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/anunciosIndex.css') ?>" />
=======
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" integrity="sha256-5veQuRbWaECuYxwap/IOE/DAwNxgm4ikX7nrgsqYp88=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.7.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/valoraciones.js') ?>"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js" integrity="sha256-XCdgoNaBjzkUaEJiauEq+85q/xi/2D4NcB3ZHwAapoM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js" integrity="sha256-GcByKJnun2NoPMzoBsuCb4O2MKiqJZLlHTw3PJeqSkI=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script>
  $(document).ready(function() {
    var calendarEl = $('#calendar')[0];
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth', // Establecer la vista inicial como "mes"
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: '' // Eliminar las opciones de vista semanal y diaria
      },
      views: { // Definir las opciones de vista disponibles
        timeGridWeek: { // Desactivar la vista semanal
          type: 'timeGrid',
          duration: { weeks: 1 },
          buttonText: 'Semana'
        },
        timeGridDay: false // Desactivar la vista diaria
      },
      events: '<?php echo resuelve('/vistas/helpers/eventosInscritos.php'); ?>'
    });
    calendar.render();
  });
</script>



    <script type="text/javascript" src="<?= $params['app']->resuelve('/js/mensajes.js') ?>"></script>

    
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
</body>
</html>
