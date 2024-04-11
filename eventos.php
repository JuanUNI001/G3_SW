<?php

require_once 'includes/config.php';
require_once 'includes/src/Eventos/listaEventos.php';



$eventos = listaeventos();
$tituloPagina = 'Eventos';
$contenidoPrincipal=<<<EOF
    $eventos
EOF;
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
