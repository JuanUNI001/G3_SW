<?php

//Inicio del procesamiento
session_start();

require_once 'includes/config.php';

$tituloPagina = 'Profesores';

$contenidoPrincipal=<<<EOS
	<h1>Profesor 1</h1>
	<p>Descripción</p>
EOS;

require 'includes/vistas/comun/layout.php';
