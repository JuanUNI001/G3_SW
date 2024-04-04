<?php

require_once 'includes/config.php';
require_once 'includes/src/Eventos/listaEventos.php';



$eventos = listaeventos();
$tituloPagina = 'Eventos';
$contenidoPrincipal=<<<EOF
    $eventos
EOF;

require_once 'includes/vistas/comun/layout.php';
?>
