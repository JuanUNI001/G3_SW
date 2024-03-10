<?php

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventos.php';
$tituloPagina = 'Eventos';

$contenidoPrincipal = mostrarEventos();

<<<EOS
	<h1>Evento 1</h1>
	<p>descripción</p>
EOS;

require 'includes/vistas/comun/layout.php';
