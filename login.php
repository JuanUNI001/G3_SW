
<?php

require_once __DIR__.'/includes/config.php';

$formLogin = new \es\ucm\fdi\aw\src\usuarios\FormularioLogin();
$formLogin = $formLogin->gestiona();


$tituloPagina = 'Login';
$contenidoPrincipal=<<<EOF
  <div class="centerer">
  	<h1>Acceso al sistema</h1>
    $formLogin
  </div>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Login'];
$app->generaVista('/plantillas/plantilla.php', $params);
