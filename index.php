<?php

//Inicio del procesamiento
session_start();

require_once 'includes/config.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require 'includes/vistas/comun/layout.php';
