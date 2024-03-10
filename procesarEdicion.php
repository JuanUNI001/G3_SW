<?php

//Inicio del procesamiento
session_start();

$nombreActual = $_POST['nombreActual'] ?? null;
$nombreNuevo = $_POST['nombreNuevo'] ?? null; 
$precioNuevo = $_POST['precioNuevo'] ?? null; 
$eliminar = $_POST['eliminar'] ?? null; 

require_once 'includes/config.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require 'includes/vistas/comun/layout.php';