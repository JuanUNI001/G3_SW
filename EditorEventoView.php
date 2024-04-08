<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Eventos\Evento;

$form = new es\ucm\fdi\aw\src\Eventos\FormularioEdicionEvento();

$id_Evento = $_GET['id_evento'];
$Evento = Evento::buscaPorId($id_Evento);
$nombre = $Evento->getNombre();

$form->id = $id_Evento;
$form->nombre = $nombre;
$form->precio = $Evento->getPrecio();
$form->descripcion = $Evento->getDescripcion();
$form->imagen = $Evento->getImagen();

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Evento';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Login'];
$app->generaVista('/plantillas/plantilla.php', $params);