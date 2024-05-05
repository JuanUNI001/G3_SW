<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventosInscritosSinCalendario.php';

$tituloPagina = 'Eventos Inscritos';

$contenidoPrincipal =  mostrarEventosInscritosSinCal();
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
