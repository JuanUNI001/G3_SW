<?php

require_once __DIR__.'/../../config.php'; 
use \es\ucm\fdi\aw\src\Foros\Foro;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
if (!$app->usuarioLogueado())  {
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}
$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);

$idAutor = $usuario->getId();

$form = new es\ucm\fdi\aw\src\Foros\FormularioCrearForo(resuelve('/foros.php'), $idAutor);


$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Creador foro';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Creador Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);