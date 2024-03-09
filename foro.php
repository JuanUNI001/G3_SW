<?php
//Inicio del procesamiento
session_start();

require_once 'includes/config.php';

$tituloPagina = 'Foro';

$contenidoPrincipal=<<<EOS
	<h1>Discusión 1</h1>
	<p>Comentario1</p>
EOS;

require 'includes/vistas/comun/layout.php';
