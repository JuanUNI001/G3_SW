<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

$form = new es\ucm\fdi\aw\src\Usuarios\FormularioEdicionUsuario();

$id_usuario = $_GET['id'];
$Usuario = Usuario::buscaPorId($id_usuario);
$nombre = $Usuario->getNombre();

$form->id = $id_usuario;
$form->nombre = $nombre;
$form->rol = $Usuario->getrolUser();
$form->correo = $Usuario->getCorreo();
$form->avatar = $Usuario->getAvatar();
//$form->imagen = "";


$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Usuario';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Usuario'];
$app->generaVista('/plantillas/plantilla.php', $params);