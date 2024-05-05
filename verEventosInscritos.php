<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventosInscritos.php';

$tituloPagina = 'Eventos Inscritos';

// Obtener el JSON de los eventos utilizando la función mostrarEventosInscritos()
$eventosJSON = mostrarEventosInscritos();

// Construir el contenido principal con el script de FullCalendar y el div con el id "calendar"
$contenidoPrincipal = <<<HTML
<div style="max-width:1000px" id="calendar"></div>
<script>   $eventosJSON </script>

HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
