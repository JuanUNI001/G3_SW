<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Productos\Producto;

$form = new es\ucm\fdi\aw\src\Productos\FormularioAddEvento();


$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Crear evento';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Creador Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);