<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Eventos\Evento;


$idEvento = $_GET['id'];

$evento = Evento::buscaPorId($idEvento);

$form = new es\ucm\fdi\aw\src\Eventos\FormularioEdicionEvento($evento);

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor evento';
$contenidoPrincipal=<<<EOF
  	
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);