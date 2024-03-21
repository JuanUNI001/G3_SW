<?php

require_once 'includes/config.php';
require_once 'includes/src/Productos/listaEventos.php';



$eventos = listaeventos();
$tituloPagina = 'Eventos';
$contenidoPrincipal=<<<EOF
    $eventos
EOF;

require_once 'includes/vistas/comun/layout.php';
?>
