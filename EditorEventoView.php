<?php

require_once 'includes/config.php'; 

use \es\ucm\fdi\aw\src\Eventos\Evento;

$id_Evento = $_GET['id'];
$evento = Evento::buscaPorId($id_Evento);

$form = new es\ucm\fdi\aw\src\Eventos\FormularioEdicionEvento($evento);

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Evento';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Evento'];
$app->generaVista('/plantillas/plantilla.php', $params);