<?php

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventos.php';
$tituloPagina = 'Eventos';

$contenidoPrincipal = mostrarEventos();

require 'includes/vistas/comun/layout.php';
