<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

$id_usuario = $_GET['id'];
$usuario = Usuario::buscaPorId($id_usuario);

$form = new es\ucm\fdi\aw\src\Usuarios\FormularioEdicionUsuario($usuario);

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Usuario';
$contenidoPrincipal=<<<EOF
  	
    $htmlFormLogin
EOF;

$scripts = [
  'js/edicionUsuario.js'
];

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Usuario', 'scripts' => $scripts];
$app->generaVista('/plantillas/plantilla.php', $params);