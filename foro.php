<?php
//Inicio del procesamiento
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';
//require_once 'includes/vistas/helpers/mensajes.php';
require_once 'includes/vistas/helpers/foro.php';
$tituloPagina = 'Foro'; 

$contenidoPrincipal = '<h1>Bienvenido al Foro</h1>';
$contenidoPrincipal .= mostrarListaForos();

//$contenidoPrincipal .= listaMensajes();
if (estaLogado()) {
	//$formNuevoMensaje = mensajeForm('mensajes/nuevoMensaje.php', 'Nuevo mensaje: ', 'Crear');
	$contenidoPrincipal .= <<<EOS
		<h1>Nuevo Tablon</h1>
		$formNuevoMensaje
	EOS;
}

require 'includes/vistas/comun/layout.php';
