<?php
//Inicio del procesamiento

require_once 'includes/config.php';
//require_once 'includes/vistas/helpers/autorizacion.php';
//require_once 'includes/vistas/helpers/mensajes.php';
require_once 'includes/vistas/helpers/foro.php';
$tituloPagina = 'Foro'; 

$contenidoPrincipal = mostrarListaForos();

require 'includes/vistas/comun/layout.php';
