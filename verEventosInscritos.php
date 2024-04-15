<?php


require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventosInscritos.php';

$tituloPagina = 'Eventos Inscritos';

$contenidoPrincipal =  mostrarEventosInscritos();
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);