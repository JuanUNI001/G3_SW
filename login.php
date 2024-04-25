
<?php

require_once __DIR__.'/includes/config.php';

$formLogin = new \es\ucm\fdi\aw\src\Usuarios\FormularioLogin();
$formLogin = $formLogin->gestiona();


$tituloPagina = 'Login';
$contenidoPrincipal=<<<EOF
  <div class="centerer">
  	<h1>Inicio de sesión</h1>
    $formLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Login'];
$app->generaVista('/plantillas/plantilla.php', $params);
