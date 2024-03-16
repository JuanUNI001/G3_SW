<?php
//Inicio del procesamiento
session_start();

require_once 'includes/config.php';

$tituloPagina = 'Eventos';

$contenidoPrincipal=<<<EOS
	<h1>Evento 1</h1>
	<p>descripción</p>
EOS;

require 'includes/vistas/comun/layout.php';
